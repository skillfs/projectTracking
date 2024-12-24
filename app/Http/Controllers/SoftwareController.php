<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Software;
use App\Models\Department;
use App\Http\Requests\SaveSoftwareRequest;
use Illuminate\Support\Facades\Auth;

class SoftwareController extends Controller
{
    const PAGINATION_COUNT = 10; // Default pagination count

    public function index()
    {
        return view('softwares.index', [
            'softwares' => Software::orderBy('created_at', 'desc')->paginate(self::PAGINATION_COUNT)
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $departments = Department::all(); // Fetch all departments

        return view('softwares.create', [
            'user' => $user,
            'departments' => $departments,
        ]);
    }

    public function store(SaveSoftwareRequest $request)
    {
        $software = Software::create($request->validated());

        return redirect()->route('softwares.list', $software)
            ->with('status', 'Software Created Successfully');
    }

    public function show(Software $software)
    {
        return view('softwares.show', compact('software'));
    }

    public function edit(Software $software)
    {
        $departments = Department::all(); // Make sure you fetch departments
        return view('softwares.edit', compact('software', 'departments'));
    }

    public function update(Request $request, Software $software)
    {
        $user = Auth::user();
        $userRole = $user->role()->first() ? $user->role()->first()->role_name : '';
        $newStatus = $request->input('status');

        // If an approval/rejection action is being taken
        if ($newStatus === 'canceled') {
            // Cancel requested software
            $software->status = 'canceled';
            $software->approved_by_dh = false;
            $software->approved_by_admin = false;
            $software->save();

            return redirect()->route('softwares.list')->with('status', 'Request Canceled');
        }

        if ($newStatus === 'approved by DH' && $userRole === 'Department Head') {
            $software->status = 'approved by DH';
            $software->approved_by_dh = true;
            $software->save();

            return redirect()->route('softwares.show', $software->software_id)->with('status', 'DH Approved Successfully');
        }

        if ($newStatus === 'approved by admin' && $userRole === 'Admin' && $software->approved_by_dh) {
            $software->status = 'queued'; // next stage after admin approval
            $software->approved_by_admin = true;
            $software->save();

            return redirect()->route('softwares.show', $software->software_id)->with('status', 'Admin Approved Successfully');
        }

        // If we reach this point, it means there's no 'newStatus' handling, so we assume it's a normal update.
        // For normal updates, use SaveSoftwareRequest for validation
        $validated = $request->validate([
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'department_id' => 'required|exists:departments,department_id',
            'tel' => 'required|digits:10',
            'status' => 'nullable|string',
            'software_name' => 'required|string',
            'problem' => 'required|string',
            'purpose' => 'required|string',
            'target' => 'required|string',
            'date' => 'required|date',
            // If you want to allow updating the file and status here, add rules for them as well
        ]);

        $software->update($validated);
        return redirect()->route('softwares.show', $software->software_id)->with('status', 'Software Updated Successfully');
    }


    public function destroy(Software $software)
    {
        $software->delete();

        return redirect()->route('softwares.list')
            ->with('status', 'Software Deleted Successfully');
    }

    /**
     * List all software requests based on user role.
     * - Admin: See all requests.
     * - Department Head: See requests with matching department_id.
     * - Normal User: See only their requests.
     */
    public function listRequests(Request $request)
    {
        $user = Auth::user();
        $userRole = $user && $user->role()->first() ? $user->role()->first()->role_name : '';
        // $userDepartmentId = $user->getAttribute('department');
        $routeName = $request->route()->getName();

        // Default: show all requests
        $query = \App\Models\Software::query();

        // Check which route is being accessed
        if ($routeName === 'softwares.dhApprovals' && $userRole === 'Department Head') {
            // Filter requests waiting for DH approval
            // e.g., all software that have 'pending' status
            $query->where('status', 'pending')
                ->where('department_id', $user->department);
        } elseif ($routeName === 'softwares.adminApprovals' && $userRole === 'Admin') {
            // Filter requests waiting for Admin approval
            // e.g., all software that have 'approved by DH' status
            $query->whereIn('status', ['approved by DH', 'queued', 'in progress']);
        } elseif ($routeName === 'softwares.myRequests') {
            // My Requests (filter by logged-in user’s name)
            $query->where('f_name', $user->f_name)
                ->where('l_name', $user->l_name);
        }

        // Order by newest first
        $softwares = $query->orderBy('created_at', 'desc')->get();

        return view('softwares.list', compact('softwares'));
    }

    public function updateDuration(Request $request, $id)
    {
        $validatedData = $request->validate([
            'timeline_start' => 'required|date',
            'timeline_end' => 'required|date|after_or_equal:timeline_start',
        ]);

        $software = Software::findOrFail($id);

        $software->update([
            'timeline_start' => $validatedData['timeline_start'],
            'timeline_end' => $validatedData['timeline_end'],
        ]);

        return redirect()->back()->with('success', 'Timeline duration updated successfully!');
    }
}
