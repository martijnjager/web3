<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Status
 *
 * @property int $id
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereValue($value)
 * @mixin \Eloquent
 */
class Status extends Model
{
    protected $table = 'status';

    public const FINISHED = 3;

    public const NOT_RUNNING = 1;

    public const RUNNING = 2;
}
