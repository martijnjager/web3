<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\File
 *
 * @property int $id
 * @property string $path
 * @property int $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Project $project
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class File extends Model
{
    public function project()
    {
        return $this->belongsTo('App\Project');
    }//
}
