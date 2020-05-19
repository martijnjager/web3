<?php

namespace App;

use App\Helpers\SaveModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $role_id
 * @property string|null $profile_image
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Project[] $project
 * @property-read int|null $project_count
 * @property-read \App\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;
    use SaveModel;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public function project()
    {
        return $this->belongsToMany('App\Project', 'user_projects', 'user_id', 'project_id');
    }

    public function getProfileImage()
    {
        return auth()->user()->profile_image != '' ? '/'.auth()->user()->profile_image : '';
    }

    public function isClient()
    {
        return $this->role_id == Role::CLIENT;
    }

    public function isDeveloper()
    {
        return $this->role_id == Role::DEVELOPER;
    }

    public function isAdministrator()
    {
        return $this->role_id == Role::ADMINISTRATOR;
    }

    public function getDevelopers()
    {
        $users = [];
        foreach(User::all() as $user) {
            if($user->isDeveloper())
                $users[] = $user;
        }

        return $users;
    }

    public function contributesTo(Project $project)
    {
        foreach ($this->project as $p) {
            if($p->id == $project->id)
                return true;
        }

        return false;
    }
}
