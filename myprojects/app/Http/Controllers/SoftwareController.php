<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Software;
use App\Http\Requests\SaveSoftwareRequest;

class SoftwareController extends Controller
{
    const PAGINATION_COUNT = 10; // Default pagination count

    public function index()
    {
        $software = Software::all(); // Fetch all software requests (can be empty)
        return view('home', compact('software'));
        // return view('softwares.index', [
        //     'softwares' => Software::orderBy('created_at', 'desc')->paginate(self::PAGINATION_COUNT)
        // ]);
    }

    public function create()
    {
        return view('softwares.create');
    }

    public function store(SaveSoftwareRequest $request)
    {
        $software = Software::create($request->validated());

        return redirect()->route('softwares.show', $software)
            ->with('status', 'Software Created Successfully');
    }

    public function show(Software $software)
    {
        return view('softwares.show', compact('software'));
    }

    public function edit(Software $software)
    {
        return view('softwares.edit', compact('software'));
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

        return redirect()->route('softwares.index')
            ->with('status', 'Software Deleted Successfully');
    }
}
