<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Timer
 *
 * @property int $id
 * @property string $start_time
 * @property string|null $end_time
 * @property int $task_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Task $task
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timer newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Timer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timer query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timer whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timer whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Timer whereTaskId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Timer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Timer withoutTrashed()
 * @mixin \Eloquent
 */
class Timer extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    public function task()
    {
        return $this->belongsTo('App\Task');
    }
}
