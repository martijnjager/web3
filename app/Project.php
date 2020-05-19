<?php

namespace App;

use App\Helper\Time;
use App\Helpers\SaveModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Project
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $start_time
 * @property string $deadline
 * @property string $planned_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Bug[] $bug
 * @property-read int|null $bug_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $file
 * @property-read int|null $file_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Task[] $task
 * @property-read int|null $task_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $user
 * @property-read int|null $user_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Project onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project wherePlannedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Project withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Project withoutTrashed()
 * @mixin \Eloquent
 * @property int $finished
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereFinished($value)
 */
class Project extends Model
{
    use Time;
    use SoftDeletes;
    use SaveModel;

    protected $table = 'projects';

    public function task()
    {
        return $this->hasMany('App\Task', 'project_id', 'id');
    }

    public function getPlannedTime()
    {
        $hours = substr($this->attributes['planned_time'], 0, strpos($this->attributes['planned_time'], ':'));
        if($hours < 10)
            return substr($hours, 1);

        return substr($this->attributes['planned_time'], 0, strpos($this->attributes['planned_time'], ':'));
    }

    public function user() {
        return $this->belongsToMany('App\User', 'user_projects', 'project_id', 'user_id');
    }
    public function bug()
    {
        return $this->hasMany('App\Bug');
    }
    public function file()
    {
        return $this->hasMany('App\File');
    }

    public function getClient()
    {
        foreach ($this->user as $user) {
            if($user->isClient())
                return $user;
        }
    }

    public function getDevelopers()
    {
        $users = [];
        foreach($this->user as $user) {
            if($user->isDeveloper())
                $users[] = $user;
        }

        return $users;
    }

    public function addFile($name)
    {
        $file = new File();
        $file->path = $name;
        $file->project_id = $this->id;
        $file->save();
    }

    public function addAppropriateMark() {
        if(Carbon::now() > $this->deadline && $this->finished) {
            echo "class='alert alert-warning'";
            return;
        }

        if($this->finished) {
            echo "class='alert alert-success'";
            return;
        }

        if(Carbon::now() > $this->deadline) {
            echo "class='alert alert-danger'";
            return;
        }
    }

    public function workedTime()
    {
        $tasks = $this->task()->get();

        $time = 0;

        foreach($tasks as $task)
        {
            $time += $this->toSeconds($task->workedTime());
        }

        return $this->secondsToTime($time);
    }

    public function getProgress()
    {
        return $this->task()->where('check', 1)->count();
    }

    public function calculateProgressWidth()
    {
        $progress = $this->getProgress();

        $count = $this->task()->count();

        if($progress > 0 && $count > 0){
            return $progress / $count  * 100;
        }

        return 0;
    }

    public function timerStatus()
    {
        foreach($this->task as $task) {
            if(strlen($task->timerStatus()) > 0) {
                echo "class='start_timer'";
                return;
            }
        }
    }

    public function finish()
    {
        if(!$this->finished)
            $this->finished = 1;
        else
            $this->finished = 0;

        $this->save();
    }
}
