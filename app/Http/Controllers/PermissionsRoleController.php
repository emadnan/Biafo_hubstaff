<?php

namespace App\Http\Controllers;
use App\Models\Permission;
use App\Models\PermissionsRole;
use App\Models\User_role;
use Illuminate\Http\Request;

class PermissionsRoleController extends Controller
{
    public function add_Role_Permissions(Request $request){
        $rolePermisson= PermissionsRole::where('role_id',$request->role_id)->get();
        // print_r($rolePermisson);
        // exit;
        $rolePermisson->delete();
        $role_id = $request->role_id;
        $permissions = $request->permissions;
        foreach($permissions as $permission)
        {

            $permissionsRole = new PermissionsRole;
            $permissionsRole->role_id = $role_id;
            $permissionsRole->permission_id = $permission;
            $permissionsRole->save();

        }

        return response()->json(['message'=>'Add Permissions As Role Successfully']);
    }
}
