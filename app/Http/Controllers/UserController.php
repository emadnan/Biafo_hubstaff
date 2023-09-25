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
use App\Mail\forGetPassword;
use App\Mail\genratePassword;


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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

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
        
        Mail::to($user->email)->send(new WelcomeEmail($mail));

        $token = JWTAuth::fromUser($user);

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
            'remember_token' => $token
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
    
        User::where('id', $id)->delete();
    
        return response()->json(['message' => 'Deleted User successfully']);
    }

    public function get_user($id)   {

        $user = User::where('id',$id)->get();

        return response()->json(['User' => $user]);
    }

    function getUsersByRoleId($role_id)    {

        $user = User::where('role',$role_id)
        ->orderBy('name', 'asc')->get();

        return response()->json(['User' => $user]);
    }

    function forGetPassword() {
        $email = \Request::input('email');
    
        $user = User::where('email', $email)->first();
        
        if ($user) {
            
            $mail = [
                'id' =>$user->id,
                'name' => $user->name,
                "email" => $user->email
            ];
            Mail::to($user->email)->send(new genratePassword($mail));
            
            return response()->json(['Message' => 'Password Updated']);
        } else {
            return response()->json(['Message' => 'User not found'], 404);
        }
    }

    function genrateNewPassword($id) {
        
        $randomNumber = mt_rand(100000, 999999);
        
        $hashedRandomNumber = bcrypt($randomNumber);
        
        $user = User::where('id', $id)->first();
        
        if ($user) {
            $user->update([
                'password' => $hashedRandomNumber
            ]);
            
            $mail = [
                'name' => $user->name,
                "password" => $randomNumber,
                "email" => $user->email
            ];
            Mail::to($user->email)->send(new forGetPassword($mail));
            return 0;
        } else {
            return response()->json(['Message' => 'User not found'], 404);
        }
    }


    function resetPassword() {

        $id = auth()->user()->id; 
        $oldPassword = \Request::input('oldPassword');
        $newPassword = \Request::input('newPassword');
        $confirmPassword = \Request::input('confirmPassword');

        $user = User::find($id);

        if ($user) {
            if (password_verify($oldPassword, $user->password)) {
                if ($newPassword === $confirmPassword) {
                    $password = bcrypt($newPassword);
                    $user->update([
                        'password' => $password
                    ]);

                    return response()->json(['Message' => 'reset Updated successfully']);
                } else {
                    return response()->json(['Message' => 'New password and confirm password do not match'], 400);
                }
            } else {
                return response()->json(['Message' => 'Old password is incorrect'], 400);
            }
        } else {
            return response()->json(['Message' => 'User not found'], 404);
        }
    }
    
}
