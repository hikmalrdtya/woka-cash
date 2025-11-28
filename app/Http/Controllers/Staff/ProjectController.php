<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchUser;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = auth()->user();

        $branchIds = BranchUser::where("user_id", $user->id)->pluck("branch_id")->toArray();
        $projectList = Project::where('branch_id', $branchIds)->get();

        return view("staff.projects.index", compact("projectList"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("staff.projects.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string",
        ]);

        $user = auth()->user();
        $branchIds = BranchUser::where("user_id", $user->id)->pluck("branch_id")->toArray();

        Project::create([
            "name" => $request->name,
            "description" => $request->description,
            "branch_id" => $branchIds[0] ?? null,
        ]);

        return redirect()->route("staff.projects.index")->with("success", "Project created successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $project = Project::findOrFail($id);
        return view("staff.projects.edit", compact("project"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $project = Project::findOrFail($id);

        $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string",
        ]);

        $project->update([
            "name" => $request->name,
            "description" => $request->description,
        ]);

        return redirect()->route("staff.projects.index")->with("success", "Project updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
