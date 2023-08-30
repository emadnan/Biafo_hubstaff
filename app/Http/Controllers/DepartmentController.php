<?php

namespace App\Http\Controllers;
use App\Models\ChangeRequestSummary;
use App\Models\Department;
use App\Models\Project;
use App\Models\FunctionalSpecificationForm;
use App\Models\ChangeRequestForm;
use App\Models\FsfHasParameter;
use App\Models\FsfHasOutputParameter;
use App\Models\Streams;
use App\Models\StreamsHasUser;
use App\Models\TaskManagement;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    function add_department()   {

        $department = new Department();
        $department->company_id = \Request::input('company_id');
        $department->department_name = \Request::input('department_name');
        $department->description = \Request::input('description');
        $department->save();
        
        return response()->json(['message'=>'Add Department successfully']);
    }

    function update_department()    {

        $id = \Request::input('id');
        $department = Department::where('id',$id)
        ->update([
            'company_id' => \Request::input('company_id'),
            'department_name' => \Request::input('department_name'),
            'description' => \Request::input('description'),

        ]);

        return response()->json(['Message' => 'Department Updated']);
    }

    public function get_department()    {

        $department = Department::select('company.*', 'company.id as company_id','departments.*')
        ->join('company','company.id','=','departments.company_id')
        ->get();

        return response()->json(['Departments' => $department]);
    }

    function delete_department()    {

        $id = \Request::input('id');
        
        $projects = Project::where('department_id', $id)->get();
        
        foreach ($projects as $project) {
            
            $fsfDeletes = FunctionalSpecificationForm::where('project_id', $project->id)->get();
            
            foreach ($fsfDeletes as $fsfDelete) {
                
                FsfHasParameter::where('fsf_id', $fsfDelete->id)->delete();
                FsfHasOutputParameter::where('fsf_id', $fsfDelete->id)->delete();
            }
            
            FunctionalSpecificationForm::where('project_id', $project->id)->delete();
            
            $crfDeletes = ChangeRequestForm::where('project_id', $project->id)->get();
            
            foreach ($crfDeletes as $crfDelete) {
                
                ChangeRequestSummary::where('crf_id', $crfDelete->id)->delete();
            }
            
            ChangeRequestForm::where('project_id', $project->id)->delete();
            
            $streamDeletes = Streams::where('project_id', $project->id)->get();
            
            foreach ($streamDeletes as $streamDelete) {
                
                StreamsHasUser::where('stream_id', $streamDelete->id)->delete();
            }
            
            TaskManagement::where('project_id', $project->id)->delete();
            Streams::where('project_id', $project->id)->delete();
            
            $project->delete();
        }
        
        Department::where('id', $id)->delete();
        
        return response()->json(['message' => 'Delete Department and associated projects and forms successfully']);
    }
    
    

    public function get_department_by_id($id)   {

        $department = Department::select('company.*', 'company.id as company_id','departments.*','departments.id as department_id')
        ->join('company','company.id','=','departments.company_id')
        ->where('departments.id',$id)
        ->get();

        return response()->json(['Departments' => $department]);
    }

}
