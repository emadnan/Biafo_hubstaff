<?php

namespace App\Http\Controllers;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    function add_department(){
        $department = new Department();
        $department->company_id = \Request::input('company_id');
        $department->department_name = \Request::input('department_name');
        $department->description = \Request::input('description');
        $department->save();
        return response()->json(['message'=>'Add Department successfully']);
    }

    function update_department(){
        $id = \Request::input('id');
        $department = Department::where('id',$id)
        ->update([
            'company_id' => \Request::input('company_id'),
            'department_name' => \Request::input('department_name'),
            'description' => \Request::input('description'),

        ]);

        return response()->json(['Message' => 'Department Updated']);
    }

    public function get_department()
    {
        $department = Department::select('company.*', 'company.id as company_id')
        ->join('company','company.id','=','departments.company_id')
        ->get();
        return response()->json(['Departments' => $department]);
    }

    function delete_department(){
        $id = \Request::input('id');
        $department = Department::where('id',$id)->delete();

        return response()->json(['message'=>'delete Department successfully']);
    }

}
