<?php
/**
 * Created by PhpStorm.
 * User: fan
 * Date: 25/08/2017
 * Time: 12:00
 */

namespace App\Http\Controllers\Rbac;


use App\Http\Controllers\Controller;
use App\Model\Permission;
use App\Model\Role;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 获取用户列表信息
     * @return array
     */
    public function getList()
    {
        $userId = auth()->user()->getAuthIdentifier();
        $userRoles = Role::getRoles([$userId]);
        $users = User::getUsers($userId);

        $roleIds = array_column($userRoles, 'role_id');
        // admin角色查看所有用户信息
        if (in_array(Role::ADMIN_ROLE, $roleIds)) {
            $users = User::getUsers();
            $userIds = array_column($users, 'id');
            $userRoles = Role::getRoles($userIds);
        }

        $roleIds = array_column($userRoles, 'role_id');
        $permissions = Permission::getPermissions($roleIds);

        $userInfo = [];
        if (empty($permissions)) {
            $userInfo = $users;
        } else {
            foreach ($users as $item => $value) {
                $userId = $value->id;
                $roleId = $value->role_id;
                $userInfo[$userId][$roleId] = $permissions[$roleId];
            }
        }

        return ['errno' => 200, 'msg' => 'ok', 'data' => $userInfo];
    }
}