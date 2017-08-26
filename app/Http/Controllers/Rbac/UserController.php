<?php
/**
 * Created by PhpStorm.
 * User: fan
 * Date: 25/08/2017
 * Time: 12:00
 */

namespace App\Http\Controllers\Rbac;


use App\Http\Controllers\Controller;
use App\Model\Common;
use App\Model\Permission;
use App\Model\Role;
use App\Model\UserRole;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 获取用户列表信息,包括角色,权限
     * @return array
     */
    public function getList()
    {
        $userId = auth()->user()->getAuthIdentifier();
        $userInfo = Common::getRolePermissionsByUser($userId);
        return ['errno' => 200, 'msg' => 'ok', 'data' => $userInfo];
    }

    /**
     * 为用户赋予角色
     * 暂定每次只能赋予一个角色，后可修改
     * @param Request $request
     * @return array
     */
    public function assignRole(Request $request)
    {
        $userId = $request->get('user_id');
        $roleId = $request->get('role_id');
        $this->validate($request, [
            'user_id' => 'required',
            'role_id' => 'required'
        ]);

        if (!User::validateUser($userId) || !Role::validateRole($roleId)) {
            return ['errno' => 400, 'msg' => '请求参数有问题', 'data' => []];
        }

        $userRole = new UserRole();
        $userRole->user_id = $userId;
        $userRole->role_id = $roleId;
        if ($userRole->save()) {
            return ['errno' => 200, 'msg' => '角色配成功', 'data' => []];
        } else {
            return Redirect::back()->withInput()->withErrors('角色分配失败，请重试');
        }
    }

    /**
     * 取消用户角色分配
     * @param Request $request
     * @return array
     */
    public function unAssignRole(Request $request)
    {
        $userId = $request->get('user_id');
        $roleId = $request->get('role_id');
        $this->validate($request, [
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        if (!User::validateUser($userId) || !Role::validateRole($roleId)) {
            return ['errno' => 400, 'msg' => '请求参数有问题', 'data' => []];
        }

        $userRole = UserRole::where(['user_id' => $userId, 'role_id' => $roleId])->firstOrFail();
        if ($userRole->delete()) {
            return ['errno' => 200, 'msg' => '取消分配成功', 'data' => []];
        } else {
            return Redirect::back()->withInput()->withErrors('取消分配失败，请重试');
        }
    }
}