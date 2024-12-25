<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Software;
use App\Models\Department;
use App\Models\Timeline;
use App\Models\UploadedFile;
use Illuminate\Support\Facades\Auth;

class SoftwareController extends Controller
{
    const PAGINATION_COUNT = 10;

    public function index()
    {
        $softwares = Software::orderBy('created_at', 'desc')
            ->paginate(self::PAGINATION_COUNT);

        return view('softwares.index', compact('softwares'));
    }

    public function create()
    {
        $user = Auth::user();
        $departments = Department::all();

        return view('softwares.create', compact('user', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'f_name'         => 'required|string|max:255',
            'l_name'         => 'required|string|max:255',
            'department_id'  => 'required|exists:departments,department_id',
            'tel'            => 'required|string|max:10',
            'date'           => 'required|date',
            'software_name'  => 'required|string|max:255',
            'problem'        => 'required|string',
            'purpose'        => 'required|string',
            'target'         => 'required|string',
            'files.*'        => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $software = Software::create($validated);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->storeAs('uploads', $file->getClientOriginalName(), 'public');
                UploadedFile::create([
                    'software_id'   => $software->software_id,
                    'original_name' => $file->getClientOriginalName(),
                    'path'          => $path,
                ]);
            }
        }

        return redirect()->route('softwares.list')
            ->with('status', 'Software request created successfully!');
    }

    public function show(Software $software)
    {
        $timelines = Timeline::where('timeline_regist_number', $software->software_id)
            ->orderBy('timeline_date', 'asc')
            ->get();

        $uploadedFiles = $software->uploadedFiles;

        return view('softwares.show', compact('software', 'timelines', 'uploadedFiles'));
    }

    public function edit(Software $software)
    {
        $departments = Department::all();
        $software->load('uploadedFiles');

        return view('softwares.edit', compact('software', 'departments'));
    }

    public function update(Request $request, Software $software)
    {
        $validatedData = $request->validate([
            'f_name'         => 'required|string',
            'l_name'         => 'required|string',
            'department_id'  => 'required|exists:departments,department_id',
            'tel'            => 'required|string|max:10',
            'date'           => 'required|date',
            'software_name'  => 'required|string',
            'problem'        => 'required|string',
            'purpose'        => 'required|string',
            'target'         => 'required|string',
            'files.*'        => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $software->update($validatedData);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->storeAs('uploads', $file->getClientOriginalName(), 'public');
                UploadedFile::create([
                    'software_id'   => $software->software_id,
                    'original_name' => $file->getClientOriginalName(),
                    'path'          => $path,
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Software updated successfully (AJAX).',
            ], 200);
        }

        return redirect()->route('softwares.show', $software->software_id)
            ->with('status', 'Software updated successfully!');
    }

    public function destroy(Software $software)
    {
        $software->delete();

        return redirect()->route('softwares.list')
            ->with('status', 'Software Deleted Successfully');
    }

    public function listRequests(Request $request)
    {
        $user       = Auth::user();
        $userRole   = $user && $user->role()->first() ? $user->role()->first()->role_name : '';
        $routeName  = $request->route()->getName();

        $query = Software::query();

        if ($routeName === 'softwares.dhApprovals' && $userRole === 'Department Head') {
            $query->where('status', 'pending')
                ->where('department_id', $user->department);
        } elseif ($routeName === 'softwares.adminApprovals' && $userRole === 'Admin') {
            $query->whereIn('status', ['approved by DH', 'queued', 'in progress']);
        } elseif ($routeName === 'softwares.myRequests') {
            $query->where('f_name', $user->f_name)
                ->where('l_name', $user->l_name);
        }

        $softwares = $query->orderBy('created_at', 'desc')->get();

        return view('softwares.list', compact('softwares'));
    }

    public function updateDuration(Request $request, Software $software)
    {
        $validatedData = $request->validate([
            'timeline_start' => 'required|date',
            'timeline_end'   => 'required|date|after_or_equal:timeline_start',
        ]);

        $software->timeline_start = $validatedData['timeline_start'];
        $software->timeline_end   = $validatedData['timeline_end'];
        $software->save();

        return redirect()->route('timelines.edit', $software->software_id)
            ->with('status', 'Development duration updated successfully!');
    }

    public function deleteFileById($fileId)
    {
        $uploadedFile = UploadedFile::findOrFail($fileId);

        if (\Storage::disk('public')->exists($uploadedFile->path)) {
            \Storage::disk('public')->delete($uploadedFile->path);
        }

        $uploadedFile->delete();

        return response()->json(['success' => true]);
    }
}
