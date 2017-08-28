<?php
/**
 * Created by PhpStorm.
 * User: fan
 * Date: 28/08/2017
 * Time: 16:15
 */

namespace App\Http\Controllers\Rbac;


use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Model\Permission;
use App\Model\Role;
use App\Model\RolePermission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 查看所拥有的角色
     * admin查看所有角色
     * @return array
     */
    public function getList()
    {
        $userId = auth()->user()->getAuthIdentifier();
        $roleInfo = Role::getRoles([$userId]);
        $roleIds = array_column($roleInfo, 'role_id');

        if (in_array(Role::ADMIN_ROLE, $roleIds)) {
            $roleInfo = Role::getRoles();
        }

        return ['errno' => 200, 'msg' => 'ok', 'data' => $roleInfo];
    }

    /**
     * 新建角色
     * @param Request $request
     * @return array
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:64',
            'description' =>'required|max:255'
        ]);
        $title = $request->get('title');
        $description = $request->get('description');
        // title去重
        $roleInfo =  Role::where(['title' => $title])->first();
        if (!empty($roleInfo)) {
            return ['errno' => 400, 'msg' => 'title 重复', 'data' => []];
        }

        $role = new Role();
        $role->title = $title;
        $role->description = $description;

        if ($role->save()) {
            return ['errno' => 200, 'msg' => 'ok', 'data' => $role->id];
        } else {
            return ['errno' => 500 ,'msg' => '新建角色失败', 'data' => []];
        }
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'title' => 'required|max:64',
            'description' =>'required|max:255'
        ]);

        $roleId = $request->get('role_id');
        $title = $request->get('title');
        $description = $request->get('description');

        if (!Role::validateRole($roleId)) {
            return ['errno' => 400, 'msg' => '请求参数有误', 'data' => []];
        }

        $roleInfo = Role::find($roleId);
        $roleInfo->title = $title;
        $roleInfo->description = $description;
        if ($roleInfo->save()) {
            return ['errno' => 200, 'msg' => '角色编辑成功', 'data' => $roleId];
        } else {
            return ['errno' => 500, 'msg' => '角色编辑失败', 'data' => []];
        }
    }

    public function delete(Request $request)
    {
        $roleId = $request->get('role_id');
        if (!Role::validateRole($roleId)) {
            return ['errno' => 400, 'msg' => '请求参数有误', 'data' => []];
        }

        $roleInfo = Role::find($roleId);
        if ($roleInfo->delete()) {
            return ['errno' => 200, 'msg' => '角色删除成功', 'data' => []];
        } else {
            return [];
        }
    }

    public function assignPermission(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'permission_id' => 'required'
        ]);
        $roleId = $request->get('role_id');
        $permissionId = $request->get('permission_id');

        if (!Role::validateRole($roleId) || !Permission::validatePermission($permissionId)) {
            return ['errno' => 400, 'msg' => '请求参数有误', 'data' => []];
        }

        $rolePermission = new RolePermission();
        $rolePermission->role_id = $roleId;
        $rolePermission->permission_id = $permissionId;
        return $rolePermission->saveOrFail();
    }

    public function unAssignPermission(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'permission_id' => 'required',
        ]);
        $roleId = $request->get('role_id');
        $permissionId = $request->get('permission_id');

        if (!Role::validateRole($roleId) || !Permission::validatePermission($permissionId)) {
            return ['errno' => 400, 'msg' => '请求参数有误', 'data' => []];
        }

        $rolePermission = RolePermission::where(['role_id' => $roleId, 'permission_id' => $permissionId])->firstOrFail();
        return $rolePermission->delete();
    }
}