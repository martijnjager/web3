<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskPost;
use App\Moscow;
use App\Project;
use App\Status;
use App\Task;
use App\Timer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class TaskController extends Controller
{
    private $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $project
     * @return \Illuminate\Http\Response
     */
    public function create($project)
    {
        $this->authorize('create-task');

        $developers = (New \App\User())->getDevelopers();
        $moscow = (new Moscow())->get();

        return view('auth.project.task.create')->with(['project' => $project, 'developers' => $developers, 'moscow' => $moscow]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Project $project
     * @param TaskPost $request
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project, TaskPost $request)
    {
        $request = $request->validated();
        $request['project_id'] = $project->id;
        $request['status_id'] = 1;
        $request['check'] = 0;
        $request['planned_time'] = "$request[planned_time]:00:00";
        $this->task->store($request);

        session()->flash('message', 'Task has been added');

        return redirect(route('auth.project.show', $project));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit($project, $task = null)
    {
        if(is_null($task))
            $task = $project;

        $task = $this->task->find($task);
        $this->authorize('update-task', $task);

        $developers = (New \App\User())->getDevelopers();
        $moscow = (new Moscow())->get();

        return view('auth.project.task.edit')->with(['task' => $task, 'developers' => $developers, 'moscow' => $moscow]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskPost $request, $project, $task)
    {
        $request = $request->validated();
        $request['planned_time'] = "$request[planned_time]:00:00";
        $task = $this->task->find($task);
        $task->store($request);
        session()->flash('message', "Task $task->title has been updated");

        return redirect(route('auth.project.show', $project));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        session()->flash('message', 'Task is deleted');

        return redirect()->back();
    }

    public function calendar()
    {
        if(auth()->user()->isAdministrator())
            $calendar = CalendarController::getAllEvents();

        if(auth()->user()->isDeveloper())
            $calendar = CalendarController::getEventsByUser();

        if(auth()->user()->isClient())
            $calendar = CalendarController::getEventsByClient();

        return view('auth.project.task.fullcalender')->with('calendar', $calendar);
    }

    public function updateStatusTimer(Task $task)
    {
        $timer = $task->timer->where('end_time', null);

        if($timer->count() == 0) {
            // we need a new timer
            $timer = new Timer();
            $timer->start_time = new Carbon();
            $timer->task_id = $task->id;
            $timer->save();
        }
        else{
            $timer = $timer->first();
            $timer->end_time  = new Carbon();
            $timer->save();

            $task->updateWorkedTime();
        }

        $task->updateStatus();

        return redirect()->back();
    }

    public function finish(Task $task)
    {
        $this->updateStatusTimer($task);

        $task->status_id = Status::FINISHED;
        $task->save();

        session()->flash('message', "$task->title is finished");

        return redirect(route('auth.project.show', $task->project_id));
    }

    public function assignUser($project, $task, $user)
    {
        $task = $this->task->find($task);
        $task->user_id = $user;
        $task->save();

        $user = (new User())->find($user);

        session()->flash('message', "$user->name is assigned to $task->title");

        return \Response::json([], 200);
    }
}
