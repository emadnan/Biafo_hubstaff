<?php

namespace App\Http\Controllers;

use App\Models\ChangeRequestForm;
use App\Models\ChangeRequestSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\addCrfMail;

class ChangeRequestFormcontroller extends Controller
{

    function addChangeRequestForm(Request $request)
    {
        // Get the input values from the request
        $project_id = $request->input('project_id');
        $module_id = $request->input('module_id');
        $fsf_id = $request->input('fsf_id');
        $company_id = $request->input('company_id');
        $functional_id = $request->input('functional_id');
        $project_manager = $request->input('project_manager');
        $reference = $request->input('reference');
        $implementation_partner = $request->input('implementation_partner');
        $issuance_date = $request->input('issuance_date');
        $author = $request->input('author');
        $doc_ref_no = $request->input('doc_ref_no');
        $requirement = $request->input('requirement');
        $required_time_no = $request->input('required_time_no');
        $required_time_type = $request->input('required_time_type');
        $functional_resource = $request->input('functional_resource');
        $Technical_resource = $request->input('Technical_resource');
        $crf_title = $request->input('crf_title');
        $type_of_requirement = $request->input('type_of_requirement');
        $priority = $request->input('priority');
        $with_in_project_scope = $request->input('with_in_project_scope');

        // Determine the CRF version
        $latestCRF = ChangeRequestForm::where('project_id', $project_id)
            ->where('module_id', $module_id)
            ->where('fsf_id', $fsf_id)
            ->orderBy('crf_version_float', 'desc')
            ->first();

        if ($latestCRF) {
            $crf_version_float = $latestCRF->crf_version_float + 1;
            $crf_version = $latestCRF->crf_version;
        } else {
            $existingCRF = ChangeRequestForm::where('project_id', $project_id)
                ->where('module_id', $module_id)
                ->orderBy('crf_version', 'desc')
                ->first();

            if ($existingCRF) {
                $crf_version = $existingCRF->crf_version + 1;
            } else {
                $crf_version = 1;
            }

            $crf_version_float = 0;
        }

        // Create a new ChangeRequestForm instance and set the properties
        $changeRequestForm = new ChangeRequestForm();
        $changeRequestForm->project_id = $project_id;
        $changeRequestForm->module_id = $module_id;
        $changeRequestForm->fsf_id = $fsf_id;
        $changeRequestForm->company_id = $company_id;
        $changeRequestForm->functional_id = $functional_id;
        $changeRequestForm->project_manager = $project_manager;
        $changeRequestForm->reference = $reference;
        $changeRequestForm->implementation_partner = $implementation_partner;
        $changeRequestForm->issuance_date = $issuance_date;
        $changeRequestForm->author = $author;
        $changeRequestForm->doc_ref_no = $doc_ref_no;
        $changeRequestForm->crf_version_float = $crf_version_float;
        $changeRequestForm->crf_version = $crf_version;

        // Save the ChangeRequestForm to the database
        $changeRequestForm->save();

        // Create a new ChangeRequestSummary instance and set the properties
        $changeRequestSummary = new ChangeRequestSummary();
        $changeRequestSummary->crf_id = $changeRequestForm->id;
        $changeRequestSummary->requirement = $requirement;
        $changeRequestSummary->required_time_no = $required_time_no;
        $changeRequestSummary->required_time_type = $required_time_type;
        $changeRequestSummary->functional_resource = $functional_resource;
        $changeRequestSummary->Technical_resource = $Technical_resource;
        $changeRequestSummary->crf_title = $crf_title;
        $changeRequestSummary->type_of_requirement = $type_of_requirement;
        $changeRequestSummary->priority = $priority;
        $changeRequestSummary->with_in_project_scope = $with_in_project_scope;

        // Save the ChangeRequestSummary to the database
        $changeRequestSummary->save();

        $CRForm = ChangeRequestForm::
        where('id', $changeRequestForm->id)
        ->with('project_details','module_details','company_details','FSF_details','crsDetails','projectManagerDetails','functionalLeadDetails')
        ->first();
        // return response()->json($CRForm);

        $mailData = [
            'issueDate' => $CRForm->issuance_date,
            'managerName' => $CRForm->projectManagerDetails->name,
            'email' => $CRForm->projectManagerDetails->email,
            'functionalLeadName' => $CRForm->functionalLeadDetails->name,
            'functionalLeadEmail' => $CRForm->functionalLeadDetails->email,
            'requirement' => $CRForm->crsDetails->$requirement,
            'required_time_no' =>$CRForm->crsDetails->$required_time_no,
            'required_time_type' =>$CRForm->crsDetails->$required_time_type,
            'crf_title' => $CRForm->crsDetails->crf_title,
            'doc_ref_no' => $CRForm->doc_ref_no,
            'crf_version' => $CRForm->crf_version,
            'crf_version_float' => $CRForm->crf_version_float,
            'priority' => $CRForm->crsDetails->priority,
            'type_of_requirement' => $CRForm->crsDetails->type_of_requirement
        ];
        
        // Send Email
        Mail::to($CRForm->email)->send(new addCrfMail($mailData));

        return response()->json(['message' => 'Change Request Form added successfully']);
    }

    


    function updateChangeRequestForm(){

        $id = \Request::input('id');
        $CRForm = ChangeRequestForm::where('id',$id)
        ->update([
            'project_id' => \Request::input('project_id'),
            'module_id' => \Request::input('module_id'),
            'fsf_id' => \Request::input('fsf_id'),
            'company_id' => \Request::input('company_id'),
            'functional_id' => \Request::input('functional_id'),
            'project_manager' => \Request::input('project_manager'),
            'reference' => \Request::input('reference'),
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
        with('projectManagerDetails','crsDetails')
        ->get();

        return response()->json(['CRForm'=>$CRForm]);
    }

    function getChangeRequestFormById($id){

        $CRForm = ChangeRequestForm::
        where('id', $id)
        ->with('project_details','module_details','company_details','FSF_details','crsDetails','projectManagerDetails')
        ->get();

        return response()->json(['CRForm'=>$CRForm]);
    }

    function getChangeRequestFormByCompanyId($company_id){

        $CRForm = ChangeRequestForm::
            where('company_id',$company_id)
            ->with('projectManagerDetails')
            ->get();

        return response()->json(['CRForm'=>$CRForm]);
    }

    function getCrfByProjectIdModuleIdAndFsfId($project_id,$module_id,$fsf_id){

        $Crf = ChangeRequestForm::
            where('project_id',$project_id)
            ->where('module_id',$module_id)
            ->where('fsf_id',$fsf_id)
            ->with('FSF_details','projectManagerDetails')
            ->get();

        return response()->json(['Crfs'=>$Crf]);
    }

    function updateStatusAndComment(){

        $id = \Request::input('id');
        $CRForm = ChangeRequestForm::where('id',$id)
        ->update([
            'status' => \Request::input('status')
        ]);
        
        return response()->json(['message'=>'Update Status Successfully']);
    }

    function updateComment(){

        $id = \Request::input('id');
        $CRForm = ChangeRequestForm::where('id',$id)
        ->update([
            'comment' => \Request::input('comment')
        ]);
        
        return response()->json(['message'=>'Update Comment Successfully']);
    }
    
    function updateCrfAndCrs(){

        $id = \Request::input('id');
        $CRForm = ChangeRequestForm::where('id',$id)
        ->update([
            'project_id' => \Request::input('project_id'),
            'module_id' => \Request::input('module_id'),
            'fsf_id' => \Request::input('fsf_id'),
            'company_id' => \Request::input('company_id'),
            'functional_id' => \Request::input('functional_id'),
            'project_manager' => \Request::input('project_manager'),
            'reference' => \Request::input('reference'),
            'issuance_date' => \Request::input('issuance_date'),
            'implementation_partner' => \Request::input('implementation_partner'),
            'author' => \Request::input('author'),
            'doc_ref_no' => \Request::input('doc_ref_no'),
            'status' => ('Pending')
        ]);

        $CRSummary = ChangeRequestSummary::where('crf_id',$id)
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

        return response()->json(['message'=>'Update CFR And CRS Successfully']);
    }
}