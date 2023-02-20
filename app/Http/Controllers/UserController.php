<?php

namespace App\Http\Controllers;
// use Mail;
use Illuminate\Http\Request;
use App\Models\ApplicantProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Traits\SmsTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignupMail;
use Illuminate\Support\Facades\Password;
use App\Models\RoleHasPermission;



class UserController extends Controller
{
    use SmsTrait;

    function applicantLogin(Request $request)
    {
        
        $profile = ApplicantProfile::join('prospect_registration','prospect_registration.applicant_profile_id','=','applicant_profile.profile_id')
        ->where('profile_email', $request->email)->first();
        
        if (!$profile || !Hash::check($request->password, $profile->profile_password)) {
            return response([ 'error' => 'Invalid email or password.'],422);
        }

        $token = $profile->createToken('token')->plainTextToken;
        
        $response = [
            'profile' => $profile,
            'token' => $token
        ];
        
         return response($response,200);
           
    }
    function signup()
    {
        
        $validator = Validator::make(\Request::all(), [
            'email' => 'required|unique:applicant_profile,profile_email',
            'name'  => 'required',
            'campus' => 'required',
            'mobile' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        $profile = new ApplicantProfile();

        $profile->profile_email = \Request::input('email');
        $profile->profile_fname = \Request::input('name');
        $profile->applied_campus = \Request::input('campus');
        $profile->profile_mobile = \Request::input('mobile');
        
        $radnom_password  = Str::random(8);
        
        $profile->profile_password = Hash::make($radnom_password);

        $subject = 'BiafoTech - Applicant Registration';


        $sms_message = "Dear ".strtoupper($profile->profile_fname).",\n";
        $sms_message .= "Thank you for registering as an applicant for admissions with Iqra University.\n";
        $sms_message .= "Email: ".$profile->profile_email."\n";
        $sms_message .= "Password: ".$radnom_password."\n";
        
        $result = $this->sendSms($profile->profile_mobile,$sms_message);

        $profile->sms_result = $result;
        
        if($profile->save()){

            $data = ['name' => $profile->profile_fname,'profile_id' => $profile->id,'to_email' => $profile->profile_email,'radnom_password' => $radnom_password];
            
            $this->send_mail($profile->profile_email,$profile->profile_fname,$radnom_password,$profile->profile_id);
            app('App\Http\Controllers\AdmissionForm')->prospect_addmission($profile->profile_id);

            return response()->json(['profile_id' => $profile->profile_id],200);
        }else{
            return response()->json(['message' => 'error'],422);
        }
    }

    function resetPassword(Request $request)
    {
         $validator = Validator::make(\Request::all(), [
            'email' => 'required',
            'old_password' => 'required',
            'new_password' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        
        $old_pass = \Request::input('old_password');
        $new_pass = \Request::input('new_password');
        

        $user = ApplicantProfile::where('profile_email',$request->email)->first();
        $user_email = $user->profile_email;
        $old_password = $user->profile_password;
      
        if(Hash::check($old_pass,$old_password)){
            $user->profile_password = Hash::make($new_pass);
            $user->save();
            return response()->json(["Message" => 'Password updated successfully']);
      
        } 

        else
        {
            return response()->json(['message' => 'error'],422);
        }
 
    }
    function adminLogin(Request $request){

        $user = User::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([ 'error' => 'Invalid email or password.'],422);
        }

        $token = $user->createToken('token')->plainTextToken;
        //$user = $user->role_id;
        $role_id=$user->role_id;
        $permissions=RoleHasPermission::join('permissions','permissions.id','=','role_has_permissions.permission_id')->where('role_has_permissions.role_id',$role_id)->get();
        
        $response = [
            'profile' => $user,
            'token' => $token,
            'permissions' => $permissions
        ];
        return response($response,200);
    }

    function send_mail($email,$name,$password,$id){

        // print_r($data1);
        // exit();

        $data = array('fname'=>$name,'pass'=>$password,'id'=>$id,'email'=>$email);
        $user['to'] =  $email;
        
        Mail::send('emails.signup', $data, function($message) use ($user){
            $message->to($user['to']);
            $message->subject(env('MAIL_FROM_ADDRESS','BiafoTech'));
            
        });
        // return response()->json(['email sent']);
    
    }
}
