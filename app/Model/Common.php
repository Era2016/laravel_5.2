<?php
/**
 * Created by PhpStorm.
 * User: fan
 * Date: 26/08/2017
 * Time: 14:46
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use App\User;


class Common extends Model
{
    /**
     * 根据用户ID，返回用户权限列表
     * @param $userId
     * @return array
     */
    public static function getPermissionsByUser($userId)
    {
        $userRoles = Role::getRoles([$userId]);
        $roleIds = array_column($userRoles, 'role_id');
        $permissions = Permission::getPermissions($roleIds);

        $userInfo = [];
        if (empty($permissions)) {
            $userInfo = [];
        } else {
            foreach ($roleIds as $item) {
                foreach ($permissions[$item] as $perId => $perInfo) {
                    $userInfo[$perId] = $permissions[$item][$perId];
                }
            }
        }
        return $userInfo;
    }

    /**
     * 根据用户ID，返回角色权限列表
     * @param $userId
     * @return array
     */
    public static function getRolePermissionsByUser($userId)
    {
        //$userId = auth()->user()->getAuthIdentifier();
        $userRoles = Role::getRoles([$userId]);
        $users = User::getUsers($userId);

        $roleIds = array_column($userRoles, 'role_id');
        // admin角色查看所有用户信息
        if (in_array(Role::ADMIN_ROLE, $roleIds)) {
            $users = User::getUsers();
            $userIds = array_column($users, 'id');
            $userRoles = Role::getRoles($userIds);
            $roleIds = array_column($userRoles, 'role_id');
        }
        $permissions = Permission::getPermissions($roleIds);

        $userInfo = [];
        if (empty($permissions)) {
            $userInfo = [];
        } else {
            foreach ($users as $item => $value) {
                //var_dump($value);exit;
                $userId = $value->id;
                $roleId = $value->role_id;
                $userInfo[$userId][$roleId] = $permissions[$roleId];
            }
        }
        return $userInfo;
    }
}