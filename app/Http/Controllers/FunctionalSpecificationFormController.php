<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\FunctionalSpecificationForm;
use App\Models\FsfHasParameter;
use App\Models\FsfAssignToUser;
use Carbon\Carbon;


use Illuminate\Http\Request;

class FunctionalSpecificationFormController extends Controller
{
    function addFunctionalSpecificationForm($step_no){
        if($step_no==1)    {
            
            $Functional = new FunctionalSpecificationForm();
            $Functional->wricef_id = \Request::input('wricef_id');
            $Functional->module_name = \Request::input('module_name');
            $Functional->functional_lead_id = \Request::input('functional_lead_id');
            $Functional->team_lead_id = \Request::input('team_lead_id');
            $Functional->requested_date = \Request::input('requested_date');
            $Functional->type_of_development = \Request::input('type_of_development');
            $Functional->priority = \Request::input('priority');
            $Functional->usage_frequency = \Request::input('usage_frequency');
            $Functional->save();

            return response()->json(['message'=>'Add Functional Specificational Form Successfully', 'id'=>$Functional->id]);
        }

        elseif($step_no==2){
            $id = \Request::input('id');
            $Functional = FunctionalSpecificationForm::where('id',$id)
            ->update([
                'transaction_code' => \Request::input('transaction_code'),
                'authorization_level' => \Request::input('authorization_level')
            ]);
            
            return response()->json(['message'=>'Add Functional Specificational Form step_no 2 Successfully']);
        }

        elseif($step_no==3)    {
            
            $fsfhasparameter = new FsfHasParameter();
            $fsfhasparameter->fsf_id = \Request::input('fsf_id');
            $fsfhasparameter->description = \Request::input('description');
            $fsfhasparameter->field_technical_name = \Request::input('field_technical_name');
            $fsfhasparameter->field_length = \Request::input('field_length');
            $fsfhasparameter->field_type = \Request::input('field_type');
            $fsfhasparameter->field_table_name = \Request::input('field_table_name');
            $fsfhasparameter->mandatory_or_optional = \Request::input('mandatory_or_optional');
            $fsfhasparameter->parameter_or_selection = \Request::input('parameter_or_selection');
            $fsfhasparameter->save();
            
            return response()->json(['message'=>'Add FSF Parameters Successfully']);
        }
        
    }    

    function updateFunctionalSpecificationForm(){

        $id = \Request::input('id');
        $Functional = FunctionalSpecificationForm::where('id',$id)
        ->update([
            'wricef_id' => \Request::input('wricef_id'),
            'module_name' => \Request::input('module_name'),
            'functional_lead_id' => \Request::input('functional_lead_id'),
            'team_lead_id' => \Request::input('team_lead_id'),
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
        
        $Functional = FunctionalSpecificationForm::
            with('getFsfParameter')
            ->get();

        return response()->json(['Functional'=>$Functional]);
    }

    function getFunctionalSpecificationFormById(){
        
        $fsf = \Request::input('fsf');
        // print_r($fsf);
        // exit();
        $Functional = FunctionalSpecificationForm::
        where('id',$fsf)
        ->with('team_lead_details','function_lead_details','getFsfParameter')
        ->get();

        return response()->json(['Functional'=>$Functional]);
    }

    function getFsfHasParameterById($id){
        
        $fsf = FsfHasParameter::where('id',$id)->get();

        return response()->json(['fsf'=>$fsf]);
    }

    function getFsfHasParameterByFsfId($fsf_id){

        $fsf = FsfHasParameter::where('fsf_id',$fsf_id)
        ->get();

        return response()->json(['fsf_has_parameter'=>$fsf]);
    }

    function DeleteFsfHasParameterByFsfId(){

        $id = \Request::input('id');

        $fsf = FsfHasParameter::where('id',$id)
        ->delete();

        return response()->json(['fsf_has_parameter'=>'delete parameters Successfully']);
    }

    function updateFsfHasParameterByFsfId(){

        $id = \Request::input('id');
        $fsf = FsfHasParameter::where('id',$id)
        ->update([

            'fsf_id' => \Request::input('fsf_id'),
            'description' => \Request::input('description'),
            'field_technical_name' => \Request::input('field_technical_name'),
            'field_length' => \Request::input('field_length'),
            'field_type' => \Request::input('field_type'),
            'field_table_name' => \Request::input('field_table_name'),
            'mandatory_or_optional' => \Request::input('mandatory_or_optional'),
            'parameter_or_selection' => \Request::input('parameter_or_selection')

        ]);
        
        return response()->json(['message'=>'Update FSF Has ParaMeter Successfully']);
    } 

    function getFunctionalSpecificationFormByTeamLeadId(){

        $Functional = FunctionalSpecificationForm::select('users.*','functional_specification_form.*')
            ->join('users','users.id','=','functional_specification_form.functional_lead_id')
            ->with('getFsfParameter')
            ->get();

        return response()->json(['Functional'=>$Functional]);
    }

    public function fsfAssignToUsers(Request $request){
           
        $user_ids = $request->user_ids;
        $fsf_id = \Request::input('fsf_id');
        $dead_line = \Request::input('dead_line');
        $assign = FsfAssignToUser::where('fsf_id',$fsf_id)->delete();
        foreach($user_ids as $user_id)
        {
            $assign = new FsfAssignToUser;
            $assign->fsf_id = $fsf_id;
            $assign->user_id = $user_id;
            $assign->dead_line = $dead_line;
            $assign->save();
        }
        return response()->json(['message'=>' FSF Assign To Users Successfully']);
    }

    function getFsfAssignToUsersByFsfId($fsf_id){

        $fsf = FsfAssignToUser::where('fsf_id',$fsf_id)
        ->get();

        return response()->json(['fsf_Assign_to_users'=>$fsf]);
    }

    function getFunctionalSpecificationFormBylogin(){
        
        $userId = Auth::id();
        $Functional = FunctionalSpecificationForm::select('fsf_assign_to_users.*','functional_specification_form.*')
        ->join('fsf_assign_to_users','fsf_assign_to_users.fsf_id','=','functional_specification_form.id')
        
        ->where('fsf_assign_to_users.user_id',$userId)
        ->with('team_lead_details','function_lead_details','getFsfParameter')
        ->get();

        return response()->json(['Functional'=>$Functional]);
    }
    function getFsfAssignToUserByLogin(){
        $userId = Auth::id();

        $fsf_Assign_to_users = FsfAssignToUser::where('user_id',$userId)
        ->get();

        return response()->json(['fsf_Assign_to_users'=>$fsf_Assign_to_users]);

    }  

    function updateStatusByLogin(){

        $userId = Auth::id();
        if(!$userId){
            return response()->json(['message'=>'user not login']);
        }
        $fsf_id = \Request::input('fsf_id');

        $fsf_Assign_to_users = FsfAssignToUser::where('fsf_id',$fsf_id)
        ->where('user_id',$userId)
        ->update([
            'status' => \Request::input('status'),
            'comment' => \Request::input('comment')
        ]);
        
        return response()->json(['message'=>'Update Status of Fsf Successfully']);
    }

    function updateStatusByTeamLogin(){

        $userId = Auth::id();

        $fsf_id = \Request::input('fsf_id');

        $fsf_Assign_to_users = FunctionalSpecificationForm::where('id',$fsf_id)
        ->where('team_lead_id',$userId)
        ->update([
            'status' => \Request::input('status'),
            'comment' => \Request::input('comment')
        ]);
        
        return response()->json(['message'=>'Update Status of Fsf Successfully']);
    }

    function getFsfAssignToUserByFsfIdAndLogin($fsf_id){
        $userId = Auth::id();
        
        // $fsf_id = \Request::input('fsf_id');
        $fsf_Assign_to_users = FsfAssignToUser::where('user_id',$userId)
        ->where('fsf_id',$fsf_id)
        ->get();

        return response()->json(['fsf_Assign_to_users'=>$fsf_Assign_to_users]);
    }

    function getFsfAssignToteamleadByFsfIdAndLogin($fsf_id){
        $id = Auth::id();
        
        // $fsf_id = \Request::input('fsf_id');
        $fsf_Assign_to_users = FunctionalSpecificationForm::where('team_lead_id',$id)
        ->where('id',$fsf_id)
        ->get();

        return response()->json(['fsf_Assign_to_users'=>$fsf_Assign_to_users]);
    }

    function getFsfFromAssignToteamleadByFsfIdAndLogin($fsf_id){
        $id = Auth::id();
        
        // $fsf_id = \Request::input('fsf_id');
        $fsf_Assign_to_users = FsfAssignToUser::where('team_lead_id',$id)
        ->where('id',$fsf_id)
        ->get();

        return response()->json(['fsf_Assign_to_users'=>$fsf_Assign_to_users]);
    }
}
