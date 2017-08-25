<?php
/**
 * Created by PhpStorm.
 * User: fan
 * Date: 24/08/2017
 * Time: 20:07
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    protected $table = 't_role';
    protected $fillable = ['title', 'description'];

    public static function getRoles($userId)
    {
        $result = DB::table('t_role')
            ->leftJoin('t_user_role', 't_role.id', '=', 't_user_role.role_id')
            ->where('t_user_role.user_id', $userId)
            ->select('t_role.*')
            ->get();
        return $result;
    }
}