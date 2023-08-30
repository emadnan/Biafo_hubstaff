<?php

namespace App\Http\Controllers;

// use Faker\Provider\Company;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\PermissionsRole;
use App\Models\ChatBox;
use App\Models\ChatBoxForTask;
use App\Models\ChatBoxFsf;
use App\Models\ChatBoxFsfToUser;
use App\Models\ProjectScreenshots;
use App\Models\StreamsHasUser;
use App\Models\ProjectScreenshotsTiming;
use App\Models\ProjectScreenshotsAttechments;
use App\Models\AssignProject;
use App\Models\FsfAssignToUser;
use App\Models\TeamHasUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;


class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        // Validate user input
        $request->validate([
            
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Get user credentials
        $credentials = $request->only('email', 'password');
        $user= User::select('users.*','users.id as user_id','company.id as company_id','company.company_name as company_name')
        ->join('company','company.id','=','users.company_id')
        ->where('email',$credentials)->first();
        $permissions = PermissionsRole::join('permissions','permissions.id','=','role_has_permissions.permission_id')
        ->where('role_id',$user->role)->get();

        try {
            // Attempt to authenticate user
            if (! $token = JWTAuth::attempt($credentials)) {
                // Authentication failed
                return response()->json(['error' => 'Invalid email or password.'], 401);
            }
        } catch (JWTException $e) {
            // Failed to generate token
            return response()->json(['error' => 'Failed to login.'], 500);
        }

        // Get authenticated user
        $User = Auth::user();

        // Authentication successful, return token and user information
        return response()->json([
            'Users'=>$user,
            'token' => $token,
            'permissions'=>$permissions
        ]);
    }
    
    public function register(Request $request) {

        // print_r($request->all());
        // exit;
        // dd($request->toArray());
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6|confirmed',
        //     // 'role_id' => 'required',
        // ]);

        // if($validator->fails()){
        //     return response()->json($validator->errors()->toJson(), 400);
        // }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        $company = new Company();
        $company->company_name= $validatedData['name'];
        $company->company_email= $validatedData['email'];
        $company->save();

        $user = new User();
        $user->company_id = $company->id;
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->role = $request->get('role');
        $user->save();

        
        // print_r($user);
        // exit();
        $token = JWTAuth::fromUser($user, [
            'name' => $request->get('name'),
            'email' => $request->get('email')
            
        ]);

        return response()->json(['message'=>'register successfully','company'=>$user]);
    }

    public function getAuthenticatedUser() {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }

    public function logout(Request $request) {
        try {
            JWTAuth::invalidate(JWTAuth::parseToken());
            return response()->json(['message' => 'Logout successfully']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Logout failed'], 500);
        }
    }

    public function change_password(Request $request){
        
        $user = \Request::input('id');
        $user = User::where('id',$user)
        ->update([
            'password' => Hash::make($request->get('password')),
        ]);

        return response()->json(['Message' => 'Password Update successfully']);
    }

    public function add_user(Request $request)
    {
        // Validate user input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        // Create a new User instance
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->company_id = $request->input('company_id');
        $user->team_id = $request->input('team_id');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $mail = [
            'name' => $user->name,
            "password" => $request->password,
            "email" => $user->email
        ];
        // Send Email
        Mail::to($user->email)->send(new WelcomeEmail($mail));

        // Generate a JWT token for the newly created user
        $token = JWTAuth::fromUser($user);

        // Return a response with the JWT token and user data
        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'User created successfully'
        ], 201);
    }

    function update_user(Request $request){
        $id = \Request::input('id');
        $token = Str::random(60);
        $user = User::where('id', $id)
        ->update([
            'company_id' => \Request::input('company_id'),
            'team_id' => \Request::input('team_id'),
            'name' => \Request::input('name'),
            'email' => \Request::input('email'),
            'role' => \Request::input('role'),
            'remember_token' => $token // Add the generated token here
        ]);
        return response()->json(['Message' => 'User Updated','token' => $token,]);
    }

    public function get_users()
    {
        $users = User::orderBy('name', 'asc')->get();
        return response()->json(['Users' => $users]);
    }
    
    function delete_user() {
        $id = \Request::input('id');
    
        ChatBoxForTask::where('user_id', $id)->delete();
        FsfAssignToUser::where('user_id', $id)->delete();
        AssignProject::where('user_id', $id)->delete();
        TeamHasUser::where('user_id', $id)->delete();
        ChatBoxFsfToUser::where('user_id', $id)->delete();
        ChatBoxFsf::where('user_id', $id)->delete();
        ChatBox::where('user_id', $id)->delete();
        StreamsHasUser::where('user_id', $id)->delete();
    
        ProjectScreenshotsTiming::whereIn('project_screenshot_id', function ($query) use ($id) {
            $query->select('id')
                ->from('project_screenshots')
                ->where('user_id', $id);
        })->delete();
        
        ProjectScreenshotsAttechments::whereIn('project_screenshot_timing_id', function ($query) use ($id) {
            $query->select('id')
                ->from('project_screenshots_timings')
                ->whereIn('project_screenshot_id', function ($subQuery) use ($id) {
                    $subQuery->select('id')
                        ->from('project_screenshots')
                        ->where('user_id', $id);
                });
        })->delete();

        ProjectScreenshots::where('user_id', $id)->delete();
    
        User::where('id', $id)->delete();
    
        return response()->json(['message' => 'Deleted User, related entities, ProjectScreenshots, ProjectScreenshotsTiming, and ProjectScreenshotsAttachments successfully']);
    }
    
    

    public function get_user($id)
    {
        $user = User::where('id',$id)->get();

        return response()->json(['User' => $user]);
    }

    function getUsersByRoleId($role_id){

        $user = User::where('role',$role_id)
        ->orderBy('name', 'asc')->get();

        return response()->json(['User' => $user]);
    }
}
