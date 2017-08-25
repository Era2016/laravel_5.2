<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
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

    public static function getUsers($userId = null)
    {
        $result = DB::table('users')
            ->leftJoin('t_user_role', 't_user_role.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 't_user_role.role_id');
        if ($userId) {
            $result->where('users.id', '=', $userId);
        }
        $result = $result->get();

        return $result;
    }
}
