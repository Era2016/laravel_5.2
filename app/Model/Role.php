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
    const ADMIN_ROLE = 1;

    protected $table = 't_role';
    protected $fillable = ['title', 'description'];

    public static function getOne($userId)
    {
        return DB::table('t_user_role')->where(['user_id', '=', $userId])->first();
    }

    /**
     * @param array $userIds
     * @return mixed
     */
    public static function getRoles(array $userIds)
    {
        // TODO get返回的是object ！！
        $result = DB::table('t_role')
            ->leftJoin('t_user_role', 't_role.id', '=', 't_user_role.role_id')
            ->whereIn('t_user_role.user_id', $userIds)
            ->select('t_role.id as role_id','t_role.title', 't_user_role.user_id')
            ->get();
        return $result;
    }
}