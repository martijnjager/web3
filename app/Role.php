<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Role
 *
 * @property int $id
 * @property string $value
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereValue($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    protected $table = 'roles';

    public const ADMINISTRATOR = 1;

    public const DEVELOPER = 2;

    public const CLIENT = 3;

    public function user()
    {
        return $this->belongsTo('App\User', 'role_id', 'id');
    }

    public function getRoles()
    {
        $roles = $this->get();
        $arr = [];
        foreach($roles as $role)
            $arr[$role->id] = $role->value;
        return $arr;
    }
}
