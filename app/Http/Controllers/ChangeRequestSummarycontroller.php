<?php

namespace App\Http\Controllers;

use App\Models\ChangeRequestSummary;
use Illuminate\Http\Request;

class ChangeRequestSummarycontroller extends Controller
{
    function addChangeRequestSummary(){

        $CRSummary = new ChangeRequestSummary();
        $CRSummary->crf_id = \Request::input('crf_id');
        $CRSummary->requirement = \Request::input('requirement');
        $CRSummary->required_time_no = \Request::input('required_time_no');
        $CRSummary->required_time_type = \Request::input('required_time_type');
        $CRSummary->functional_resource = \Request::input('functional_resource');
        $CRSummary->Technical_resource = \Request::input('Technical_resource');
        $CRSummary->crf_title = \Request::input('crf_title');
        $CRSummary->type_of_requirement = \Request::input('type_of_requirement');
        $CRSummary->priority = \Request::input('priority');
        $CRSummary->with_in_project_scope = \Request::input('with_in_project_scope');
    
        
        $CRSummary->save();
    
        return response()->json(['message' => 'Add Change Request Summary']);
    }

    function updateChangeRequestSummary(){

        $id = \Request::input('id');
        $CRSummary = ChangeRequestSummary::where('id',$id)
        ->update([
            'crf_id' => \Request::input('crf_id'),
            'requirement' => \Request::input('requirement'),
            'required_time_no' => \Request::input('required_time_no'),
            'required_time_type' => \Request::input('required_time_type'),
            'functional_resource' => \Request::input('functional_resource'),
            'crf_title' => \Request::input('crf_title'),
            'type_of_requirement' => \Request::input('type_of_requirement'),
            'priority' => \Request::input('priority'),
            'with_in_project_scope' => \Request::input('with_in_project_scope'),
            'Technical_resource' => \Request::input('Technical_resource')
        ]);
        
        return response()->json(['message'=>'Update Change Request Summary Successfully']);
    }

    function deleteChangeRequestSummary(){
        
        $id = \Request::input('id');
        $CRSummary = ChangeRequestSummary::where('id',$id)->delete();

        return response()->json(['message'=>'Delete Change Request Summary Successfully']);
    }

    function getChangeRequestSummary(){
        
        $CRSummary = ChangeRequestSummary::
        get();

        return response()->json(['CRSummary'=>$CRSummary]);
    }

    function getChangeRequestSummaryById($id){

        $CRSummary = ChangeRequestSummary::
        where('id', $id)
        ->with('crfDdetails')
        ->get();

        return response()->json(['CRSummary'=>$CRSummary]);
    }
}
