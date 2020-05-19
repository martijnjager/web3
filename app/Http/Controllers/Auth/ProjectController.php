<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectPost;
use App\Project;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\App;

class ProjectController extends Controller
{
    private $project;
    private $user;

    public function __construct(ProjectRepository $project, UserRepository $users)
    {
        $this->project = $project;
        $this->user = $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('all-projects'))
            return view('auth.project.index')->with('projects', $this->project->get());

        else
            return view('auth.project.index')->with('projects', auth()->user()->project);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-project');
        $developers = $this->user->getDevelopers();
        $clients = $this->user->getClients();

        return view('auth.project.create')->with(['developers' => $developers, 'clients' => $clients]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectPost $request)
    {
        $data = $request->validated();
        $this->project->saveNew($data);

        session()->flash('message', 'New project successfully created.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $this->authorize('view-project', $project);

        return view('auth.project.view', ['project' => $project, 'users' => $this->user->getDevelopers()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $this->authorize('update-project', $project);

        $developers = $this->user->getDevelopers();
        $clients = $this->user->getClients();
        return view('auth.project.edit')->with(['project' => $project, 'developers' => $developers, 'clients' => $clients]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectPost $request, Project $project)
    {
        $this->project->updateProject($project, $request->validated());

        session()->flash('message', "Project $project->name is successfully updated.");

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        session()->flash('message', 'Project is deleted');

        return redirect()->back();
    }

    public function finish(Project $project)
    {
        $project->finish();

        if($project->finished)
            session()->flash('message', "$project->name marked as completed.");
        else
            session()->flash('message', "$project->name not marked as completed");

        return redirect()->back();
    }
}
