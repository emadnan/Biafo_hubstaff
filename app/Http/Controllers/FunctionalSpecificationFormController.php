<?php

namespace App\Http\Controllers;
use App\Models\FunctionalSpecificationForm;
use Carbon\Carbon;


use Illuminate\Http\Request;

class FunctionalSpecificationFormController extends Controller
{
    function addFunctionalSpecificationForm(){
        $Functional = new FunctionalSpecificationForm();
        $Functional->wricef_id = \Request::input('wricef_id');
        $Functional->module_name = \Request::input('module_name');
        $Functional->functional_lead = \Request::input('functional_lead');
        $Functional->requested_date = Carbon::createFromFormat('d-m-Y', \Request::input('requested_date'))->format('Y-m-d');
        $Functional->type_of_development = \Request::input('type_of_development');
        $Functional->priority = \Request::input('priority');
        $Functional->usage_frequency = \Request::input('usage_frequency');
        $Functional->transaction_code = \Request::input('transaction_code');
        $Functional->authorization_level = \Request::input('authorization_level');
        $Functional->description = \Request::input('description');
        $Functional->field_technical_name = \Request::input('field_technical_name');
        $Functional->field_length = \Request::input('field_length');
        $Functional->field_type = \Request::input('field_type');
        $Functional->field_table_name = \Request::input('field_table_name');
        $Functional->mandatory_or_optional = \Request::input('mandatory_or_optional');
        $Functional->parameter_or_selection = \Request::input('parameter_or_selection');
        $Functional->save();

        return response()->json(['message'=>'Add Functional Specificational Form Successfully']);
    }    

    function updateFunctionalSpecificationForm(){

        $id = \Request::input('id');
        $Functional = FunctionalSpecificationForm::where('id',$id)
        ->update([
            'wricef_id' => \Request::input('wricef_id'),
            'module_name' => \Request::input('module_name'),
            'functional_lead' => \Request::input('functional_lead'),
            'requested_date' => Carbon::createFromFormat('d-m-Y', \Request::input('requested_date'))->format('Y-m-d'),
            'type_of_development' => \Request::input('type_of_development'),
            'priority' => \Request::input('priority'),
            'usage_frequency' => \Request::input('usage_frequency'),
            'transaction_code' => \Request::input('transaction_code'),
            'authorization_level' => \Request::input('authorization_level'),
            'description' => \Request::input('description'),
            'field_technical_name' => \Request::input('field_technical_name'),
            'mandatory_or_optional' => \Request::input('mandatory_or_optional'),
            'parameter_or_selection' => \Request::input('parameter_or_selection')
        ]);
        
        return response()->json(['message'=>'Update Functional Specificational Form Successfully']);
    } 

    function deleteFunctionalSpecificationForm(){
        
        $id = \Request::input('id');
        $Functional = FunctionalSpecificationForm::where('id',$id)->delete();

        return response()->json(['message'=>'Delete Functional Specificational Form Successfully']);
    }

    function getFunctionalSpecificationForm(){
        
        $Functional = FunctionalSpecificationForm::get();

        return response()->json(['Functional'=>$Functional]);
    }

    function getFunctionalSpecificationFormById(){
        
        $id = \Request::input('id');
        $Functional = FunctionalSpecificationForm::where('id',$id)->get();

        return response()->json(['Functional'=>$Functional]);
    }
}
