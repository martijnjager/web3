<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Bug
 *
 * @property int $id
 * @property string $description
 * @property int $status
 * @property int $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Project $project
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bug query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bug whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bug whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bug whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bug whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Bug whereImage($value)
 */
class Bug extends Model
{

    protected $table='bugs';
    protected $fillable = ['description', 'status', 'project_id', 'image'];
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
