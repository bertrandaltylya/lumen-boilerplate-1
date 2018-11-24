<?php

namespace App\Models\Auth\User;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use HasApiTokens;
    use HasRoles;
    use SoftDeletes;

    /**
     * all permissions
     *
     * name => value
     */
    const PERMISSIONS = [
        // basic
        'index' => 'user index',
        'create' => 'user create',
        'show' => 'user show',
        'update' => 'user update',
        'destroy' => 'user destroy',
        // deletes
        'deleted list' => 'user deleted list',
        'purge' => 'user purge',
        'restore' => 'user restore',
        // status
        'update status' => 'user update status',
        'deactivated list' => 'user deactivated list',
    ];

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
