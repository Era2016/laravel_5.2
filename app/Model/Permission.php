<?php
/**
 * Created by PhpStorm.
 * User: fan
 * Date: 24/08/2017
 * Time: 20:31
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Permission extends Model
{
    protected $table = 't_permission';
    protected $fillable = ['title', 'description'];

    public static function getPermissions(array $roleIds)
    {
        DB::connection()->enableQueryLog();
        $result = DB::table('t_permission')
            ->leftJoin('t_role_permission', 't_role_permission.permission_id', '=', 't_permission.id')
            ->whereIn('t_role_permission.role_id', $roleIds)
            ->select('t_permission.id as permission_id','t_permission.title', 't_role_permission.role_id')
            ->get();

        $log = DB::getQueryLog();
        //return dd($log);   //打印sql语句
        Log::info('get_permission:', $log);

        if (empty($result)) {
            return [];
        }

        //$result = get_object_vars($result);
        $ret = [];
        foreach ($result as $item => $value) {
            $roleId = $value->role_id;
            $ret[$roleId][] = $value;
        }
        return $ret;
    }
}