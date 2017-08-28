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
    public static function getRoles(array $userIds=[])
    {
        // WTF! get返回的是object ！！
        $result = DB::table('t_role')
            ->leftJoin('t_user_role', 't_role.id', '=', 't_user_role.role_id')
            ->select('t_role.id as role_id','t_role.title', 't_role.description', 't_user_role.user_id');

        if (!empty($userIds)) {
            $result = $result->whereIn('t_user_role.user_id', $userIds);
        }

        $result = $result->get();
        return $result;
    }

    /**
     * 验证角色有效性
     * @param $roleId
     * @return bool
     */
    public static function validateRole($roleId)
    {
        $result = DB::table('t_role')
            ->where('id', $roleId)
            ->first();
        if (empty($result)) {
            return false;
        }
        return true;
    }
}