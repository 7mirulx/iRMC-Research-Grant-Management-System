<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\ResearchGrant;
use App\Models\Academician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MilestoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $milestones = Milestone::with(['researchGrant', 'researchGrant.projectLeader'])->get();
        $researchGrants = ResearchGrant::with('projectLeader')->get();
        return view('milestones.index', compact('milestones', 'researchGrants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $researchGrants = ResearchGrant::with('projectLeader')->get();
        return view('milestones.create', compact('researchGrants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ResearchGrant $research_grant)
    {
        Gate::authorize('store', [Milestone::class, $research_grant]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'deliverable' => 'required|string',
            'target_completion_date' => 'required|date',
            'status' => 'required|in:not_started,in_progress,completed'
        ]);

        $validated['research_grant_id'] = $research_grant->id;
        $validated['last_updated'] = now();

        Milestone::create($validated);

        return redirect()->route('research-grants.show', $research_grant)
            ->with('success', 'Milestone added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Milestone $milestone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Milestone $milestone)
    {
        Gate::authorize('update', $milestone);
        $research_grant = $milestone->researchGrant;
        $academicians = Academician::all();
        
        return view('milestones.edit', compact('milestone', 'research_grant', 'academicians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Milestone $milestone)
    {
        Gate::authorize('update', $milestone);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'deliverable' => 'required|string',
            'target_completion_date' => 'required|date',
            'status' => 'required|in:not_started,in_progress,completed',
            'members' => 'required|array|min:1',
            'members.*' => 'exists:academicians,id'
        ]);

        $validated['last_updated'] = now();
        $milestone->update($validated);
        
        // Update project members
        $milestone->researchGrant->members()->sync($request->members);

        return redirect()->route('research-grants.show', $milestone->research_grant_id)
            ->with('success', 'Milestone updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Milestone $milestone)
    {
        Gate::authorize('delete', $milestone);
        
        $milestone->delete();

        return redirect()->route('milestones.index')
            ->with('success', 'Milestone deleted successfully.');
    }

    public function editStatus(Milestone $milestone)
    {
        Gate::authorize('update', $milestone);
        return view('milestones.editstatus', compact('milestone'));
    }

    public function updateStatus(Request $request, Milestone $milestone)
    {
        Gate::authorize('update', $milestone);

        $validated = $request->validate([
            'status' => 'required|in:not_started,in_progress,completed'
        ]);

        $validated['last_updated'] = now();
        $milestone->update($validated);

        return redirect()->route('research-grants.show', $milestone->research_grant_id)
            ->with('success', 'Milestone status updated successfully.');
    }

    /**
     * Store a milestone (Admin version)
     */
    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'research_grant_id' => 'required|exists:research_grants,id',
            'name' => 'required|string|max:255',
            'deliverable' => 'required|string',
            'target_completion_date' => 'required|date',
            'status' => 'required|in:not_started,in_progress,completed'
        ]);

        $validated['last_updated'] = now();
        Milestone::create($validated);

        return redirect()->route('milestones.index')
            ->with('success', 'Milestone added successfully.');
    }
}
