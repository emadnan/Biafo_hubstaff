<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PermissionsRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class UserController extends Controller
{
    public function authenticate(Request $request) {
        $credentials = $request->only('email', 'password');
        $user= User::where('email',$credentials)->first();
        // print_r($user);
        // exit();
        $permissions = PermissionsRole::join('permissions','permissions.id','=','role_has_permissions.permission_id')
        ->where('role_id',$user->role)->get();
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('user','token','permissions'));
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

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            // 'role_id' => $request->get('role_id'),
        ]);

        $token = JWTAuth::fromUser($user, [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            // 'role_id' => $request->get('role_id'),
            
        ]);

        return response()->json(['message'=>'SignUp successfully']);
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

    //ADD USERS CRUD
    function add_user(){
        $user = new User();
        $user->name = \Request::input('name');
        $user->email = \Request::input('email');
        $user->password = Hash::make('password');
        $user->role = \Request::input('role');
        $user->save();
        
        return response()->json(['message'=>'Add User successfully']);
    }

    function update_user(Request $request){
        $id = \Request::input('id');
        $user = User::where('id',$id)
        ->update([
            'name' => \Request::input('name'),
            'email' => \Request::input('email'),
            'password' => Hash::make($request->get('password')),
            'role' => \Request::input('role')
        ]);

        return response()->json(['Message' => 'User Updated']);
    }

    public function get_users()
    {
        $user = User::get();
        return response()->json(['Users' => $user]);
    }
    
    function delete_user(){
        $id = \Request::input('id');
        $user = User::where('id',$id)->delete();

        return response()->json(['message'=>'delete User successfully']);
    }

    public function get_user($id)
    {
        $user = User::where('id',$id)->get();
        return response()->json(['User' => $user]);
    }

}
