<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ScreenShotsController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication Routes
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', [UserController::class, 'getAuthenticatedUser']);
    Route::post('logout', [UserController::class, 'logout']);
    //change password
});
Route::post('/changepassword',[UserController::class,'change_password']);

//Add Roles API
Route::post('/addrole',[RoleController::class,'add_roles']);

//update user API
Route::post('/update-role',[RoleController::class,'updateRole']);

//Get roles API
Route::get('/getroles',[RoleController::class,'get_roles']);

//delete role API
Route::post('/delete-role',[RoleController::class,'delete_role']);

//Add permission API
Route::post('/addpermission',[PermissionController::class,'add_permissions']);

//Get permissions API
Route::get('/getpermissions',[PermissionController::class,'get_permissions']);

//delete permission API
Route::post('/delete-permission',[PermissionController::class,'delete_permission']);

//update user API
Route::post('/update-permission',[PermissionController::class,'updatepermission']);

//Add company API
Route::post('/addcompany',[CompanyController::class,'add_company']);

//update company API
Route::post('/update-company',[CompanyController::class,'update_company']);

//delete company API
Route::post('/delete-company',[CompanyController::class,'delete_company']);

//Get company API
Route::get('/getcompany',[CompanyController::class,'get_company']);

//Add screen_shots API
Route::post('/screen_shot',[ScreenShotsController::class,'add_screen_shots']);

// take a screenshort
Route::post('/take_screen_shot',[ScreenShotsController::class,'take_screenshort']);

//Add screen_shots API
Route::post('/update_screen_shots',[ScreenShotsController::class,'update_screen_shots']);

//Add screen_shots API
Route::get('/get_ScreenShot',[ScreenShotsController::class,'get_ScreenShot']);

//Add screen_shots API
Route::post('/delete_ScreenShot',[ScreenShotsController::class,'delete_ScreenShot']);

//Add department API
Route::post('/add_department',[DepartmentController::class,'add_department']);

//update department API
Route::post('/update-department',[DepartmentController::class,'update_department']);

//delete department API
Route::post('/delete-department',[DepartmentController::class,'delete_department']);

//Get department API
Route::get('/getdepartment',[DepartmentController::class,'get_department']);

//Get project API
Route::get('/getproject',[projectController::class,'get_projects']);

//Add project API
Route::post('/add_project',[projectController::class,'add_project']);

//update project API
Route::post('/update-project',[projectController::class,'update_project']);

//delete project API
Route::post('/delete-project',[projectController::class,'delete_project']);

//Get project API
Route::get('/get-project-by-user/{id}',[projectController::class,'get_project_by_user_id']);

//Add User API
Route::post('/add_user',[UserController::class,'add_user']);

//Update User API
Route::post('/update_user',[UserController::class,'update_user']);

//Delete User API
Route::post('/delete_user',[UserController::class,'delete_user']);

//Get All Users
Route::get('/get_users',[UserController::class,'get_users']);

//Get User By Id
Route::get('/get_user/{id}',[UserController::class,'get_user']);

//Add Team API
Route::post('/add_team',[TeamController::class,'add_team']);

//Update Team API
Route::post('/updateteam',[TeamController::class,'updateteam']);

//Delete Team API
Route::post('/delete_team',[TeamController::class,'delete_team']);

//Get All Teams
Route::get('/get_teams',[TeamController::class,'get_teams']);

//Get All Country API
Route::get('/get_country',[CountryController::class,'get_country']);

//Get All Cities API
Route::get('/get_cities/{country_id}',[CityController::class,'get_cities']);
