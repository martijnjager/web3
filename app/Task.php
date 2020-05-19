<?php

namespace App;

use App\Helper\Time;
use App\Helpers\SaveModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Task
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string|null $comment
 * @property int $status_id
 * @property int $check
 * @property string $planned_time
 * @property string $worked_time
 * @property string $start_date
 * @property string $end_date
 * @property int $project_id
 * @property int $user_id
 * @property int $moscow_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Moscow $moscow
 * @property-read \App\Status $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Timer[] $timer
 * @property-read int|null $timer_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Task onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereMoscowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task wherePlannedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Task whereWorkedTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Task withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Task withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\User $user
 */
class Task extends Model
{
    use SoftDeletes;
    use Time;
    use SaveModel;

    protected $fillable = [
        'user_id'
    ];

    public function getPlannedTime()
    {
        $hours = substr($this->attributes['planned_time'], 0, strpos($this->attributes['planned_time'], ':'));
        if($hours < 10)
            return substr($hours, 1);

        return substr($this->attributes['planned_time'], 0, strpos($this->attributes['planned_time'], ':'));
    }

    public function user() {
        return $this->belongsTo('APp\User');
    }

    public function timer()
    {
        return $this->hasMany('App\Timer');
    }

    public function moscow()
    {
        return $this->hasOne('App\Moscow', 'id', 'moscow_id');
    }

    public function status() {
        return $this->hasOne('App\Status', 'id', 'status_id');
    }

    public function addAppropriateMark() {
        if($this->worked_time > $this->planned_time && $this->check) {
           echo "class='alert alert-warning'";
           return;
        }
        if($this->check) {
           echo "class='alert alert-success'";
        }
        if($this->worked_time > $this->planned_time) {
           echo "class='alert alert-danger'";
        }
    }

    public function timerStatus() {
        if($this->status->value == "running")
            echo "class='start_timer'";

    }

    public function updateStatus()
    {
        if($this->status_id == Status::RUNNING)
            $this->status_id = Status::NOT_RUNNING;
        else
            $this->status_id = Status::RUNNING;
        $this->save();
    }

    public function updateWorkedTime()
    {
        $this->worked_time = $this->workedTime();
        $this->save();
    }

    public function workedTime()
    {
        return $this->secondsToTime($this->getTimers());
    }

    public function getTimers()
    {
        $time = 0;
        foreach($this->timer as $timer) {
            if($timer->end_time != null) {
                $beginTime = strtotime($timer->start_time);
                $endTime = strtotime($timer->end_time);
                $time += $endTime - $beginTime;
            }

            if($timer->end_time == null) {
                $beginTime = strtotime($timer->start_time);
                $endTime = strtotime(Carbon::now());
                $time += $endTime - $beginTime;
            }
        }

        return $time;
    }

    public function isFinished()
    {
        return $this->status->value == 'finished';
    }
}
