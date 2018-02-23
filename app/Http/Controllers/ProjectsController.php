<?php

namespace App\Http\Controllers;

use App\Project;
use App\Worker;
use Bestit\HipChat\Facade\HipChat;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all(['id', 'name']);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = new Project;

        $project->name = $request->name;
        $project->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        $project->name = $request->name;

        $project->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        $project->delete();
        return back();
    }

    /**
     * Add Employee to the specified project.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function addEmployee(Request $request, $id)
    {
        $project = Project::find($id);
        $employee = Worker::find($request->id);
        if (!$employee->projects()->find($project->id)) {
            $employee->projects()->save($project);
            HipChat::user($employee->email)->notify('(jobs) Nerd We need your support for ' . $project->name . ' Project!');
        } else {
            return back()
                ->withErrors([
                    'Allready exist' => 'Worker does not exist : ',
                ], 'loginErrors');
        }

        return back();
    }

    /**
     * Add Employee to the specified project.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEmployee(Request $request, $id)
    {
        $project = Project::find($id);
        $employee = Worker::find($request->id);
        if ($employee->projects()->find($project->id)) {
            $employee->projects()->detach($project);
            HipChat::user($employee->email)->notify('You have been kicked out form ' . $project->name . ' Project! (facepalm)');
        }

        return back();
    }
}
