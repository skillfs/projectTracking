<?php

namespace App\Http\Controllers;

use App\Models\Software;
use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // You can add middleware to ensure only Admin access if needed
        // $this->middleware('admin'); // If you have an admin middleware
    }

    public function edit(Software $software)
    {
        // Ensure only Admins can access this page
        $user = Auth::user();
        $userRole = $user->role()->first() ? $user->role()->first()->role_name : '';
        if ($userRole !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Fetch timelines for this software, even if it's empty
        $timelines = Timeline::where('timeline_regist_number', $software->software_id)
            ->orderBy('timeline_date', 'desc')
            ->get();

        return view('timelines.edit', compact('software', 'timelines'));
    }

    public function editTimeline(Timeline $timeline)
    {
        // Ensure only Admins can access this page
        $user = Auth::user();
        $userRole = $user->role()->first() ? $user->role()->first()->role_name : '';
        if ($userRole !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Return the edit view for the timeline
        return view('timelines.editTimeline', compact('timeline'));
    }

    public function store(Request $request, Software $software)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'timeline_date' => 'required|date',
            'timeline_step' => 'required|string',
            'other_timeline_step' => 'nullable|string', // Only required if "Other" is selected
        ]);

        // Determine the correct timeline step
        $timelineStep = $validatedData['timeline_step'];
        if ($timelineStep === 'Other' && $request->filled('other_timeline_step')) {
            $timelineStep = $request->input('other_timeline_step'); // Use the custom value
        }

        // Create a new timeline entry
        Timeline::create([
            'timeline_regist_number' => $software->software_id,
            'timeline_date' => $validatedData['timeline_date'],
            'timeline_step' => $timelineStep, // Use the correct timeline step (predefined or custom)
            // 'recorded_by' => $user->f_name . ' ' . $user->l_name,
        ]);

        // Update the software status
        if ($timelineStep === 'Complete') {
            $software->status = 'completed';
        } else {
            $software->status = 'in progress';
        }
        $software->save();

        return redirect()->route('timelines.edit', $software->software_id)
            ->with('status', 'Timeline entry added successfully');
    }


    public function update(Request $request, Timeline $timeline)
    {
        $validatedData = $request->validate([
            'timeline_date' => 'required|date',
            'timeline_step' => 'required|string',
        ]);

        if ($request->timeline_step === 'Other' && $request->has('other_timeline_step')) {
            $validatedData['timeline_step'] = $request->other_timeline_step; // Use the custom value
        }

        $timeline->update($validatedData);

        // Redirect to the timelines.edit page for the associated software
        return redirect()->route('timelines.edit', $timeline->timeline_regist_number)
            ->with('status', 'Timeline updated successfully!');
    }

    public function destroy(Timeline $timeline)
    {
        // Ensure only Admins can delete timelines
        $user = Auth::user();
        $userRole = $user->role()->first() ? $user->role()->first()->role_name : '';
        if ($userRole !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $timeline->delete();

        return redirect()->back()->with('status', 'Timeline entry deleted successfully!');
    }
}
