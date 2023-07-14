<?php

namespace App\Http\Controllers;

use App\Models\ChangeRequestForm;
use Illuminate\Http\Request;

class ChangeRequestFormcontroller extends Controller
{
    function addChangeRequestForm(){

        $CRForm = new ChangeRequestForm();
        $CRForm->project_id = \Request::input('project_id');
        $CRForm->module_id = \Request::input('module_id');
        $CRForm->fsf_id = \Request::input('fsf_id');
        $CRForm->company_id = \Request::input('company_id');
        $CRForm->implementation_partner = \Request::input('implementation_partner');
        $CRForm->issuance_date = \Request::input('issuance_date');
        $CRForm->author = \Request::input('author');
        $CRForm->doc_ref_no = \Request::input('doc_ref_no');
        $CRForm->save();

        
        return response()->json(['message'=>'Add Change Request Form']);
    }

    function updateChangeRequestForm(){

        $id = \Request::input('id');
        $CRForm = ChangeRequestForm::where('id',$id)
        ->update([
            'project_id' => \Request::input('project_id'),
            'module_id' => \Request::input('module_id'),
            'fsf_id' => \Request::input('fsf_id'),
            'company_id' => \Request::input('company_id'),
            'issuance_date' => \Request::input('issuance_date'),
            'implementation_partner' => \Request::input('implementation_partner'),
            'author' => \Request::input('author'),
            'doc_ref_no' => \Request::input('doc_ref_no')
        ]);
        
        return response()->json(['message'=>'Update Change Request Form Successfully']);
    }

    function deleteChangeRequestForm(){
        
        $id = \Request::input('id');
        $CRForm = ChangeRequestForm::where('id',$id)->delete();

        return response()->json(['message'=>'Delete Change Request Form Successfully']);
    }

    function getChangeRequestForm(){
        
        $CRForm = ChangeRequestForm::
            get();

        return response()->json(['CRForm'=>$CRForm]);
    }
}
