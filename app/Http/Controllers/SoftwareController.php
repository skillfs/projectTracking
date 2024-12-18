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

    public function update(SaveSoftwareRequest $request, Software $software)
    {
        $software->update($request->validated());

        return redirect()->route('softwares.show', $software)
            ->with('status', 'Software Updated Successfully');
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
    public function listRequests()
    {
        $user = Auth::user();

        // Admin: See all software requests
        if ($user->role()->first()->role_name === 'Admin') {
            $softwares = Software::orderBy('created_at', 'desc')->get();
        }
        // Department Head: See requests matching department_id
        elseif ($user->role()->first()->role_name === 'Department Head') {
            $softwares = Software::where('department_id', $user->department)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        // Normal User: See only their own requests
        else {
            $softwares = Software::where('f_name', $user->f_name)
                ->where('l_name', $user->l_name)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Return the view with filtered software requests
        return view('softwares.list', compact('softwares'));
    }
}
