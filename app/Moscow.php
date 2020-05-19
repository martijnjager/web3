<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Moscow
 *
 * @property int $id
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moscow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moscow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moscow query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moscow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Moscow whereValue($value)
 * @mixin \Eloquent
 */
class Moscow extends Model
{
    protected $table = 'moscow';
}
