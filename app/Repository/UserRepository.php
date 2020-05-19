<?php
namespace App\Repository;

use App\Role;
use App\User;

/**
 * App\Repository\UserRepository
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\UserRepository newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\UserRepository newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\UserRepository query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\UserRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\UserRepository whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\UserRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\UserRepository whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\UserRepository wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\UserRepository whereProfileImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\UserRepository whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\UserRepository whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Repository\UserRepository whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserRepository extends User
{
    public function store(array $data)
    {
        parent::store($data);
    }

    public function updateById($id, array $data)
    {
        parent::find($id)->store($data);
    }

    public function getDevelopers()
    {
        return $this->getUsersByRole(Role::DEVELOPER);
    }

    public function getClients()
    {
        return $this->getUsersByRole(Role::CLIENT);
    }

    private function getUsersByRole($id)
    {
        $devs = $this->where('role_id', $id)->get();

        $d = [];

        foreach($devs as $dev) {
            $d[$dev->id] = $dev->name;
        }

        return $d;
    }
}
