<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\FunctionalSpecificationForm;
use App\Models\FsfHasParameter;
use App\Models\FsfHasOutputParameter;
use App\Models\FsfAssignToUser;
use App\Models\Module;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\FunctionalSpacificationForm;
use App\Mail\sendFsfMaliTeamLeadToTeamMembers;


use Illuminate\Http\Request;

class FunctionalSpecificationFormController extends Controller
{
    function addFunctionalSpecificationForm(){

        $Functional = new FunctionalSpecificationForm();
        $Functional->reference_id = \Request::input('reference_id');
        $Functional->module_id = \Request::input('module_id');
        $Functional->project_id = \Request::input('project_id');
        $Functional->company_id = \Request::input('company_id');
        $Functional->description = \Request::input('description');
        $Functional->type_of_development = \Request::input('type_of_development');
        $Functional->wricef_id = \Request::input('wricef_id');
        $Functional->functional_lead_id = \Request::input('functional_lead_id');
        $Functional->ABAP_team_lead_id = \Request::input('ABAP_team_lead_id');
        $Functional->requested_date = \Request::input('requested_date');
        $Functional->priority = \Request::input('priority');
        $Functional->usage_frequency = \Request::input('usage_frequency');
        $Functional->transaction_code = \Request::input('transaction_code');
        $Functional->authorization_role = \Request::input('authorization_role');
        $Functional->development_logic = \Request::input('development_logic');

        $screenShots = \Request::input('attachment');

            if (!empty($screenShots)) {
                $image = str_replace('data:image/png;base64,', '', $screenShots);
                $image = str_replace(' ', '+', $image);
                $imageName = uniqid() . '.' . 'png';
                \File::put(public_path() . '/attachment/' . $imageName, base64_decode($image));
                $Functional->attachment = $imageName;

            }

        $latestFSF = FunctionalSpecificationForm::where('project_id',$Functional->project_id)->where('module_id',$Functional->module_id)->orderBy('fsf_version', 'desc')->first();

            if ($latestFSF) {
                $Functional->fsf_version = $latestFSF->fsf_version + 1;
            } else {
                $Functional->fsf_version = 1;
            }

        $Functional->save();

        // Email 
        $Functional1 = FunctionalSpecificationForm::
            select('modules.*','projects.*','modules.name as Module_name','functional_specification_form.*')
            ->join('projects','projects.id','=','functional_specification_form.project_id')
            ->join('modules','modules.id','=','functional_specification_form.module_id')
            ->where('functional_specification_form.id',$Functional->id)
            ->with('team_lead_details','function_lead_details','getFsfInputParameter','getFsfOutputParameter')
            ->first();
            
            $mailData = [
                'ModuleName' => $Functional1->Module_name,
                'ProjectName' => $Functional1->project_name,
                'wricefId' => $Functional1->wricef_id,
                'priorities' => $Functional1->priority,
                'TypeOfDevelopment' => $Functional1->type_of_development,
                'teamLeadName' => $Functional1->team_lead_details->name,
                'teamLeadEmail' => $Functional1->team_lead_details->email,
                'FunctionalLeadName' => $Functional1->function_lead_details->name,
                'FunctionalLeadEmail' => $Functional1->function_lead_details->email
            ];
            
            // Send Email
            Mail::to($Functional1->team_lead_details->email)->send(new FunctionalSpacificationForm($mailData));

        return response()->json(['message'=>'Add Functional Specificational Form Successfully','id'=>$Functional->id]);

    }

    function updateFunctionalSpecificationForm(){

        $id = \Request::input('id');
        $Functional = FunctionalSpecificationForm::where('id',$id)
        ->update([
            'reference_id' => \Request::input('reference_id'),
            'module_id' => \Request::input('module_id'),
            'project_id' => \Request::input('project_id'),
            'company_id' => \Request::input('company_id'),
            'description' => \Request::input('description'),
            'type_of_development' => \Request::input('type_of_development'),
            'requested_date' => \Request::input('requested_date'),
            'wricef_id' => \Request::input('wricef_id'),
            'functional_lead_id' => \Request::input('functional_lead_id'),
            'ABAP_team_lead_id' => \Request::input('ABAP_team_lead_id'),
            'priority' => \Request::input('priority'),
            'usage_frequency' => \Request::input('usage_frequency'),
            'transaction_code' => \Request::input('transaction_code'),
            'development_logic' => \Request::input('development_logic')
        ]);
        
        return response()->json(['message'=>'Update Functional Specificational Form Successfully']);
    } 

    function addFsfHasInputParameters()   {
        
        $fsfhasparameter = new FsfHasParameter();
        $fsfhasparameter->fsf_id = \Request::input('fsf_id');
        $fsfhasparameter->description = \Request::input('description');
        $fsfhasparameter->input_parameter_name = \Request::input('input_parameter_name');
        $fsfhasparameter->field_technical_name = \Request::input('field_technical_name');
        $fsfhasparameter->field_length = \Request::input('field_length');
        $fsfhasparameter->field_type = \Request::input('field_type');
        $fsfhasparameter->field_table_name = \Request::input('field_table_name');
        $fsfhasparameter->mandatory_or_optional = \Request::input('mandatory_or_optional');
        $fsfhasparameter->parameter_or_selection = \Request::input('parameter_or_selection');
        $fsfhasparameter->save();
        
        return response()->json(['message'=>'Add FSF input Parameters Successfully']);
    }
    
    function UpdateFsfHasInputParameterByFsfId(){

        $id = \Request::input('id');
        $fsf = FsfHasParameter::where('id',$id)
        ->update([

            'fsf_id' => \Request::input('fsf_id'),
            'description' => \Request::input('description'),
            'input_parameter_name' => \Request::input('input_parameter_name'),
            'field_technical_name' => \Request::input('field_technical_name'),
            'field_length' => \Request::input('field_length'),
            'field_type' => \Request::input('field_type'),
            'field_table_name' => \Request::input('field_table_name'),
            'mandatory_or_optional' => \Request::input('mandatory_or_optional'),
            'parameter_or_selection' => \Request::input('parameter_or_selection')

        ]);
        
        return response()->json(['message'=>'Update FSF Has input ParaMeter Successfully']);
    }

    function addFsfOutputParameters()   {
        
        $fsfhasparameter = new FsfHasOutputParameter();
        $fsfhasparameter->fsf_id = \Request::input('fsf_id');
        $fsfhasparameter->description = \Request::input('description');
        $fsfhasparameter->output_parameter_name = \Request::input('output_parameter_name');
        $fsfhasparameter->field_technical_name = \Request::input('field_technical_name');
        $fsfhasparameter->field_length = \Request::input('field_length');
        $fsfhasparameter->field_type = \Request::input('field_type');
        $fsfhasparameter->field_table_name = \Request::input('field_table_name');
        $fsfhasparameter->mandatory_or_optional = \Request::input('mandatory_or_optional');
        $fsfhasparameter->parameter_or_selection = \Request::input('parameter_or_selection');
        $fsfhasparameter->save();
        
        return response()->json(['message'=>'Add FSF output Parameters Successfully']);
    }

    function UpdateFsfHasOutputParameterByFsfId(){

        $id = \Request::input('id');
        $fsf = FsfHasOutputParameter::where('id',$id)
        ->update([

            'fsf_id' => \Request::input('fsf_id'),
            'description' => \Request::input('description'),
            'output_parameter_name' => \Request::input('output_parameter_name'),
            'field_technical_name' => \Request::input('field_technical_name'),
            'field_length' => \Request::input('field_length'),
            'field_type' => \Request::input('field_type'),
            'field_table_name' => \Request::input('field_table_name'),
            'mandatory_or_optional' => \Request::input('mandatory_or_optional'),
            'parameter_or_selection' => \Request::input('parameter_or_selection')

        ]);
        
        return response()->json(['message'=>'Update FSF Has output ParaMeter Successfully']);
    }

    function getFsfHasOutputParameters($id){
        
        $FsfHasOutputParameters = FsfHasOutputParameter::where('fsf_id', $id)
        ->get();

        return response()->json(['fsf_has_output_parameters'=>$FsfHasOutputParameters]);
    }

    function getFsfHasOutputParameterById($id){
        
        $FsfHasOutputParameters = FsfHasOutputParameter::
        where('id',$id)
        ->get();

        return response()->json(['fsf_has_output_parameter'=>$FsfHasOutputParameters]);
    }

    function deleteFunctionalSpecificationForm(){
        
        $id = \Request::input('id');
        $Functional = FunctionalSpecificationForm::where('id',$id)->delete();

        return response()->json(['message'=>'Delete Functional Specificational Form Successfully']);
    }

    function getFunctionalSpecificationForm(){
        
        $Functional = FunctionalSpecificationForm::
            with('getFsfInputParameter')
            ->get();

        return response()->json(['Functional'=>$Functional]);
    }

    function getFunctionalSpecificationFormById($fsf){
        
        $Functional = FunctionalSpecificationForm::
        select('modules.*','projects.*','modules.name as Module_name','functional_specification_form.*')
        ->join('projects','projects.id','=','functional_specification_form.project_id')
        ->join('modules','modules.id','=','functional_specification_form.module_id')
        ->where('functional_specification_form.id',$fsf)
        ->with('team_lead_details','function_lead_details','getFsfInputParameter','getFsfOutputParameter')
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

    function DeleteFsfHasOutputParameterByFsfId($id){

        $fsf = FsfHasOutputParameter::where('id',$id)
        ->delete();

        return response()->json(['fsf_has_parameter'=>'delete Fsf has Output Parameters Successfully']);
    }
     

    function getFunctionalSpecificationFormByTeamLeadId(){

        $Functional = FunctionalSpecificationForm::select('users.*','functional_specification_form.*')
            ->join('users','users.id','=','functional_specification_form.functional_lead_id')
            ->with('getFsfInputParameter')
            ->get();

        return response()->json(['Functional'=>$Functional]);
    }

    
    public function fsfAssignToUsers(Request $request)
    {
        $user_ids = $request->user_ids;
        $fsf_id = $request->input('fsf_id');
        $dead_line = $request->input('dead_line');
    
        // Fetch all existing assignments for the given fsf_id
        $existingAssignments = FsfAssignToUser::where('fsf_id', $fsf_id)->get();
    
        // Get the user_ids of existing assignments
        $existingUserIds = $existingAssignments->pluck('user_id')->toArray();
    
        // Identify user_ids to delete (those not in the new user_ids list)
        $userIdsToDelete = array_diff($existingUserIds, $user_ids);
    
        // Delete old data for user_ids that are not in the new list
        FsfAssignToUser::where('fsf_id', $fsf_id)->whereIn('user_id', $userIdsToDelete)->delete();
    
        // Insert new data for user_ids that don't already exist
        foreach ($user_ids as $user_id) {
            if (!in_array($user_id, $existingUserIds)) {
                $assign = new FsfAssignToUser;
                $assign->fsf_id = $fsf_id;
                $assign->user_id = $user_id;
                $assign->dead_line = $dead_line;
                $assign->save();
    
                // Send email notification
                $user = user::find($user_id); // Replace with the logic to get the user's email
                if ($user) {
                    $member = FunctionalSpecificationForm::
                        select('modules.*','projects.*','modules.name as Module_name','functional_specification_form.*')
                        ->join('projects','projects.id','=','functional_specification_form.project_id')
                        ->join('modules','modules.id','=','functional_specification_form.module_id')
                        ->where('functional_specification_form.id',$user->id)
                        ->with('team_lead_details','function_lead_details','memberDetails')
                        ->first();
                        
                        $mailData = [
                            'ModuleName' => $member->Module_name,
                            'ProjectName' => $member->project_name,
                            'wricefId' => $member->wricef_id,
                            'priorities' => $member->priority,
                            'TypeOfDevelopment' => $member->type_of_development,
                            'teamLeadName' => $member->team_lead_details->name,
                            'teamLeadEmail' => $member->team_lead_details->email,
                            'memberName' => $member->memberDetails->name,
                            'memberEmail' => $member->memberDetails->email
                        ];
                    Mail::to($user->email)->send(new sendFsfMaliTeamLeadToTeamMembers($mailData));
                }
            }
        }
    
        return response()->json(['message' => 'FSF Assign To Users Successfully']);
    }
    
    



    function getFsfAssignToUsersByFsfId($fsf_id){

        $fsf = FsfAssignToUser::where('fsf_id',$fsf_id)
        ->get();

        return response()->json(['fsf_Assign_to_users'=>$fsf]);
    }

    function getFunctionalSpecificationFormBylogin(){
        
        $userId = Auth::id();
        $Functional = FunctionalSpecificationForm::select('fsf_assign_to_users.*','functional_specification_form.*','fsf_assign_to_users.status as assign_status')
        ->join('fsf_assign_to_users','fsf_assign_to_users.fsf_id','=','functional_specification_form.id')
        ->join('users','users.id','=','fsf_assign_to_users.user_id')
        
        ->where('fsf_assign_to_users.user_id',$userId)
        ->with('team_lead_details','function_lead_details','getFsfInputParameter')
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
        ->where('ABAP_team_lead_id',$userId)
        ->update([
            'status' => \Request::input('status')
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
        $fsf_Assign_to_users = FunctionalSpecificationForm::where('ABAP_team_lead_id',$id)
        ->where('id',$fsf_id)
        ->get();

        return response()->json(['fsf_Assign_to_users'=>$fsf_Assign_to_users]);
    }

    function getFsfFromAssignToteamleadByFsfIdAndLogin($fsf_id){
        
        // $fsf_id = \Request::input('fsf_id');
        $fsf_Assign_to_users = FsfAssignToUser::
        join('users','users.id','=','fsf_assign_to_users.user_id')
        ->where('fsf_id',$fsf_id)
        ->get();

        return response()->json(['fsf_Assign_to_users'=>$fsf_Assign_to_users]);
    }

    function getModules(){
        $Module = Module::
            get();
        return response()->json(['Module'=>$Module]);
    }

    public function addDevelopmentLogicIntoFsfForm()
    {
        $screenShots = \Request::input('screenShots');

        if (!empty($screenShots)) {

            $image = str_replace('data:image/png;base64,', '', $screenShots);
            $image = str_replace(' ', '+', $image);
            $imageName = uniqid() . '.' . 'png';
            \File::put(public_path() . '/development_logics/' . $imageName, base64_decode($image));
            $path_url =$imageName;
            return response()->json(['path_url'=>$path_url]);
        }
        else{
            
            return response()->json(['message'=>'Developmentlogic Not Found']);
        }
    }

    public function addInputScreen($id)
    {
        $screenShots = \Request::input('screenShots');

        if (!empty($screenShots)) {
            $image = str_replace('data:image/png;base64,', '', $screenShots);
            $image = str_replace(' ', '+', $image);
            $imageName = uniqid() . '.' . 'png';
            \File::put(public_path() . '/input_screens/' . $imageName, base64_decode($image));
            $path_url = FunctionalSpecificationForm::
            where('id',$id)
            ->update([
                'input_screen' => $imageName
            ]);

            return response()->json(['message'=>'input_screen Updated']);
        }
        else    {
            
            return response()->json(['message'=>'input_screen Not Found']);
        }
    }

    public function addOutputScreen($id)
    {
        $screenShots = \Request::input('screenShots');

        if (!empty($screenShots)) {
            $image = str_replace('data:image/png;base64,', '', $screenShots);
            $image = str_replace(' ', '+', $image);
            $imageName = uniqid() . '.' . 'png';
            \File::put(public_path() . '/output_screens/' . $imageName, base64_decode($image));
            $path_url = FunctionalSpecificationForm::
            where('id',$id)
            ->update([
                'output_screen' => $imageName
            ]);

            return response()->json(['message'=>'output_screen Updated']);
        }
        else    {
            
            return response()->json(['message'=>'output_screen Not Found']);
        }
    }
    
    function getFsfByProjectIdAndModuleId($project_id,$module_id){

        $fsf = FunctionalSpecificationForm::
            where('project_id',$project_id)
            ->where('module_id',$module_id)
            ->get();

        return response()->json(['FSFs'=>$fsf]);
    }

}
