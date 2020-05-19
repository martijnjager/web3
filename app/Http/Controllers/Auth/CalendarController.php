<?php

namespace App\Http\Controllers\Auth;

use App\Project;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class CalendarController extends Controller
{
    public static function getAllEvents() {
        $tasks = new Task();

        return self::getEvents($tasks->get());
    }

    public static function getEventsByUser()
    {
        $tasks = Task::whereUserId(auth()->id())->get();

        return self::getEvents($tasks);
    }

    public static function getEventsByClient()
    {
        $tasks = [];
        foreach(auth()->user()->project as $project) {
            $tasks[] = $project->task;
        }

        return self::getEvents($tasks[0]);
    }

    private static function getEvents($tasks)
    {
        $events = [];

        foreach($tasks as $task) {
            $events[] = Calendar::event(
                $task->title,
                true,
                $task->start_date,
                $task->end_date,
                $task->id
            );
        }

        return Calendar::addEvents($events)->setCallbacks([
            'eventClick' => "function(event) {
            $.ajax({
                url: '/dashboard/project/task/' + event.id + '/edit',
                type: 'GET',
                success: function(result) {
                    // loading modal into the page
                    $('.modal-content').html(result);
                    $('#exampleModal').modal('show');
                },
                error: function (e) {
                    console.log('Error processing your request: ' + e.responseText);
                }
            });}",
        ]);
    }
}
