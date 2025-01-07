<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return response()->json($projects);
    }

    public function show($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], 400);
        }

        return response()->json($project);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $project = Project::create($request->all());

        return response()->json($project, 200);
    }

    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $project->update($request->all());

        return response()->json($project);
    }

    public function destroy($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], 400);
        }

        $project->delete();

        return response()->json(['message' => 'Uspesno izbrisan']);
    }
}
