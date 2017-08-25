<?php
/**
 * Created by PhpStorm.
 * User: fan
 * Date: 24/08/2017
 * Time: 19:44
 */

namespace App\Http\Controllers\Rbac;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\Permission;
use App\Model\Role;

class ShowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 获取当前用户所有的权限列表
     * @return array
     */
    public function getAuthList()
    {
        // 获取用户ID，角色，通过角色判断当前用户有哪些权限
        $user = auth()->user();
        //var_dump($user);
        $userId = $user->getAuthIdentifier();
        $arrRoles = Role::getRoles($userId);
        //var_dump($arrRoles);
        $roleIds = array_column($arrRoles, 'id');
        $arrPermissions = Permission::getPermissions($roleIds);
        return ['errno' => 200, 'msg' => 'ok', 'data' => $arrPermissions];
    }

}