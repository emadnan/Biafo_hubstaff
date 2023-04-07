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
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PermissionsRoleController;
use App\Http\Controllers\AssignProjectController;
use App\Http\Controllers\StreamsController;
use App\Http\Controllers\ProjectScreenshotsController;

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
Route::post('register', [UserController::class, 'add_user']);
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

//Get role by id API

Route::get('/get_roles_by_id/{id}',[RoleController::class,'get_roles_by_id']);

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

//get permission by role id
Route::get('/get-permission-by-id/{id}',[PermissionController::class,'get_permission_by_id']);

//get permission by id
Route::get('/get-permissions-by-id/{id}',[PermissionController::class,'get_permissions_by_id']);

//role_has_permissions
Route::post('/role-permissions',[PermissionsRoleController::class,'add_Role_Permissions']);

//Add company API
Route::post('/addcompany',[CompanyController::class,'add_company']);

//update company API
Route::post('/update-company',[CompanyController::class,'update_company']);

//delete company API
Route::post('/delete-company',[CompanyController::class,'delete_company']);

//Get company API
Route::get('/getcompany',[CompanyController::class,'get_company']);

//Get company by id API
Route::get('/get_company_by_id/{id}',[CompanyController::class,'get_company_by_id']);

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

//Get department API
Route::get('/getdepartment-by-id/{id}',[DepartmentController::class,'get_department_by_id']);

//Get project API
Route::get('/getproject',[projectController::class,'get_projects']);

//Add project API
Route::post('/add_project',[projectController::class,'add_project']);

//update project API
Route::post('/update-project',[projectController::class,'update_project']);

//delete project API
Route::post('/delete-project',[projectController::class,'delete_project']);

//Get project API
Route::get('/get-project-by-project-id/{project_id}',[projectController::class,'get_project_by_project_id']);

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

//Add Client API
Route::post('/add_client',[ClientController::class,'add_client']);

//Update Client API
Route::post('/update_client',[ClientController::class,'update_client']);

//get Client API
Route::GET('/get_client',[ClientController::class,'get_client']);

//get Client by id API
Route::GET('/get_client_by_id/{id}',[ClientController::class,'get_cliente_by_id']);

//Delete Client
Route::post('/delete_client',[ClientController::class,'delete_client']);

//Assign Projects API
Route::post('/assign_projects',[AssignProjectController::class,'assign_projects']);

//Get Assign Projects API
Route::get('/get_assign_projects',[AssignProjectController::class,'get_assign_projects']);

//Deloete Assign Projects API
Route::post('/delete_assign_projects',[AssignProjectController::class,'delete_assign_projects']);


//Update Assign Projects API
Route::post('/update_assign_projects',[AssignProjectController::class,'update_assign_projects']);

//Get Assign Projects API
Route::get('/get_assign_project_by_project_id/{project_id}/{stream_id}',[AssignProjectController::class,'get_assign_project_by_project_id']);

//get project by users 
Route::get('/get-project-by-user-id/{id}',[projectController::class,'get_project_by_user_id']);

//get all streams 
Route::get('/get-streams',[StreamsController::class,'get_streams']);

// Add screenshots API\
Route::post('/Add_project_screenshots',[ProjectScreenshotsController::class,'addProjectScreenshot']);

// Add screenshots API\
Route::get('/get_Project_Screenshots',[ProjectScreenshotsController::class,'getProjectScreenshots']);