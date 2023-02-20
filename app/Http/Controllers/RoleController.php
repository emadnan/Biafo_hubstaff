<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    function add_roles(){
        $role = new Role();
        $role->name = \Request::input('name');
        $role->guard_name = 'APi';
        $role->save();
        return response()->json(['message'=>'Add role successfully']);
    }

    function updateRole(){
        $id = \Request::input('id');
        $role = Role::where('id',$id)
        ->update([
            'name' => \Request::input('name'),
            'guard_name' => 'API'
        ]);

        return response()->json(['Message' => 'Role Updated']);
    }

    public function get_roles()
    {
        $role = Role::get();
        return response()->json(['roles' => $role]);
    }

    function delete_role(){
        $id = \Request::input('id');
        $role = Role::where('id',$id)->delete();

        return response()->json(['message'=>'delete role successfully']);
    }

}
