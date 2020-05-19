<?php

namespace App\Repository;

use App\Project;
use App\Role;
use Carbon\Carbon;

/**
 * App\Repository\ProjectRepository
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\ProjectRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\ProjectRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\ProjectRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\ProjectRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\ProjectRepository whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\ProjectRepository whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\ProjectRepository whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\ProjectRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\ProjectRepository whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\ProjectRepository wherePlannedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\ProjectRepository whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\ProjectRepository whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Bug[] $bug
 * @property-read int|null $bug_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $file
 * @property-read int|null $file_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Task[] $task
 * @property-read int|null $task_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $user
 * @property-read int|null $user_count
 * @property int $finished
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\ProjectRepository whereFinished($value)
 */
class ProjectRepository extends Project
{
    public function saveNew(array $request)
    {
        $users = $request['users'];
        $users[] = $request['client'];

        unset($request['users'], $request['client']);

        $this->store($request);

        $p = $this->get()->last();

        $p->user()->attach($users);
    }

    public function updateProject(Project $project, array $request)
    {
        $users = $request['users'];
        $users[] = $request['client'];

        unset($request['users'], $request['client']);

        $request['planned_time'] = "$request[planned_time]:00:00";

        $project->store($request);

        // Remove relations first, then add them again
        $project->user()->detach();

        $project->user()->attach($users);
    }
}
