<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Site;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // ── Store new project under a site ───────────────────────────────
    public function store(Request $request, Site $site)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'project_code'        => 'nullable|string|max:50',
            'type'                => 'required|in:Fabrication,Erection,Civil,Structural,Maintenance,Other',
            'status'              => 'required|in:planning,ongoing,on_hold,completed',
            'start_date'          => 'nullable|date',
            'expected_end_date'   => 'nullable|date',
            'contract_value'      => 'nullable|numeric|min:0',
            'progress_percent'    => 'nullable|integer|min:0|max:100',
            'description'         => 'nullable|string',
        ]);

        $validated['site_id']          = $site->id;
        $validated['progress_percent'] = $validated['progress_percent'] ?? 0;

        Project::create($validated);

        return redirect()->route('admin.sites.show', $site)
            ->with('success', 'Project "' . $validated['name'] . '" added.');
    }

    // ── Update project ───────────────────────────────────────────────
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'project_code'        => 'nullable|string|max:50',
            'type'                => 'required|in:Fabrication,Erection,Civil,Structural,Maintenance,Other',
            'status'              => 'required|in:planning,ongoing,on_hold,completed',
            'start_date'          => 'nullable|date',
            'expected_end_date'   => 'nullable|date',
            'contract_value'      => 'nullable|numeric|min:0',
            'progress_percent'    => 'nullable|integer|min:0|max:100',
            'description'         => 'nullable|string',
        ]);

        $project->update($validated);

        return redirect()->route('admin.sites.show', $project->site)
            ->with('success', 'Project updated.');
    }

    // ── Delete project ───────────────────────────────────────────────
    public function destroy(Project $project)
    {
        $site = $project->site;
        $project->delete();
        return redirect()->route('admin.sites.show', $site)
            ->with('success', 'Project deleted.');
    }
}