<?php

namespace App\Http\Controllers;

use App\Models\ResearchGrant;
use App\Models\Academician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResearchGrantController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $grants = ResearchGrant::with('projectLeader')->get();
        } else {
            $academician = Auth::user()->academician;
            $grants = ResearchGrant::where('project_leader_id', $academician->id)
                ->orWhereHas('members', function ($query) use ($academician) {
                    $query->where('academician_id', $academician->id);
                })
                ->with('projectLeader')
                ->get();
        }
        
        return view('research-grants.index', compact('grants'));
    }

    public function create()
    {
        if (Auth::user()->role === 'admin') {
            $academicians = Academician::all();
        } else {
            $academicians = Academician::where('id', '!=', Auth::user()->academician_id)->get();
        }
        
        return view('research-grants.create', compact('academicians'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_leader_id' => 'required|exists:academicians,id',
            'title' => 'required|string|max:255',
            'grant_amount' => 'required|numeric|min:0',
            'grant_provider' => 'required|string|max:255',
            'start_date' => 'required|date',
            'duration_months' => 'required|integer|min:1',
            'members' => 'required|array|min:1',
            'members.*' => 'exists:academicians,id'
        ]);

        if (!Auth::user()->role === 'admin') {
            $validated['project_leader_id'] = Auth::user()->academician_id;
        }

        $grant = ResearchGrant::create($validated);
        $grant->members()->attach($request->members);

        return redirect()->route('research-grants.index')
            ->with('success', 'Research grant created successfully.');
    }

    public function show(ResearchGrant $research_grant)
    {
        $research_grant->load(['projectLeader', 'members', 'milestones']);
        return view('research-grants.show', compact('research_grant'));
    }

    public function edit(ResearchGrant $research_grant)
    {
        $academicians = Academician::all();
        return view('research-grants.edit', compact('research_grant', 'academicians'));
    }

    public function update(Request $request, ResearchGrant $research_grant)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'grant_amount' => 'required|numeric|min:0',
            'grant_provider' => 'required|string|max:255',
            'start_date' => 'required|date',
            'duration_months' => 'required|integer|min:1',
            'members' => 'required|array|min:1',
            'members.*' => 'exists:academicians,id'
        ]);

        $research_grant->update($validated);
        $research_grant->members()->sync($request->members);

        return redirect()->route('research-grants.show', $research_grant)
            ->with('success', 'Research grant updated successfully.');
    }

    public function destroy(ResearchGrant $research_grant)
    {
        // First detach all members
        $research_grant->members()->detach();
        
        // Then delete milestones
        $research_grant->milestones()->delete();
        
        // Finally delete the research grant
        $research_grant->delete();
        
        return redirect()->route('research-grants.index')
            ->with('success', 'Research grant deleted successfully.');
    }
}
