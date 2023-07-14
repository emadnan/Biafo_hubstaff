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
use App\Http\Controllers\FunctionalSpecificationFormController;
use App\Http\Controllers\TaskManagementController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ChangeRequestFormcontroller;


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

// Register API
Route::post('register', [UserController::class, 'register']);

//login API
Route::post('login', [UserController::class, 'authenticate']);

//All Auths APIs
Route::group(['middleware' => ['jwt.verify']], function() {

    //get authenticated user
    Route::get('user', [UserController::class, 'getAuthenticatedUser']);

    //Logout API
    Route::post('logout', [UserController::class, 'logout']);

    //get total sum of time work in all projects
    Route::get('/getSum',[ProjectScreenshotsController::class,'sum']);

    //get FsF by team lead id
    Route::get('/getFunctionalSpecificationFormByTeamLeadId',[FunctionalSpecificationFormController::class,'getFunctionalSpecificationFormByTeamLeadId']);
    
    // get FSF By login API
    Route::get('/getFunctionalSpecificationFormBylogin',[FunctionalSpecificationFormController::class,'getFunctionalSpecificationFormBylogin']);

    // get FSF assign to user by login API
    Route::get('/getFsfAssignToUserByLogin',[FunctionalSpecificationFormController::class,'getFsfAssignToUserByLogin']);

    //update status of fsf assign to user API
    Route::post('updateStatusByLogin', [FunctionalSpecificationFormController::class, 'updateStatusByLogin']);

    //update status of fsf by team lead API
    Route::post('updateStatusByTeamLogin', [FunctionalSpecificationFormController::class, 'updateStatusByTeamLogin']);

    //Add Task by team lead login API
    Route::post('addTasks', [TaskManagementController::class, 'addTasks']);

    // get FSF assign to user by login API
    Route::get('/getFsfAssignToUserByFsfIdAndLogin/{fsf_id}',[FunctionalSpecificationFormController::class,'getFsfAssignToUserByFsfIdAndLogin']);

    // get FSF assign to user by login API
    Route::get('/getFsfAssignToteamleadByFsfIdAndLogin/{fsf_id}',[FunctionalSpecificationFormController::class,'getFsfAssignToteamleadByFsfIdAndLogin']);

    // calculating weekly worked
    Route::get('/calculateWeeklyWork',[ProjectScreenshotsController::class,'calculateWeeklyWork']);
});

//get total time by userId, projectId, and StreamName
Route::get('/get_totalTime/{userId}/{projectId}/{streamsName}',[ProjectScreenshotsController::class,'getTotalTimebyUserId']);

// get total work time by user id
Route::get('/getTotalWorkbyUserId/{userId}',[ProjectScreenshotsController::class,'getTotalWorkbyUserId']);

//Change Password
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

//Get company by user id API
Route::get('/getCompanyByUserId/{user_id}',[CompanyController::class,'getCompanyByUserId']);

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

//Add screen_shots API
Route::post('/saveFile',[ScreenShotsController::class,'saveFile']);

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

//Get Team by ID
Route::get('/getTeam/{team_id}',[TeamController::class,'getTeamById']);

//team has users
Route::post('/teamHasUsers',[TeamController::class,'teamHasUsers']);

//team has users
Route::get('/getUsersByTeamId/{team_id}',[TeamController::class,'getUsersByTeamId']);

//team has users
Route::get('/getUsersByRoleId/{role_id}',[UserController::class,'getUsersByRoleId']);

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

//Add stream API
Route::post('/addStreams',[StreamsController::class,'addStreams']);

//Update stream API
Route::post('/updateStream',[StreamsController::class,'updateStream']);

//Delete stream API
Route::post('/deleteStream',[StreamsController::class,'deleteStream']);

//get all streams by company id
Route::get('/getStreamById/{id}',[StreamsController::class,'getStreamById']);

//get all streams 
Route::get('/getStreamByCompanyId/{id}',[StreamsController::class,'getStreamByCompanyId']);

//get all streams 
Route::get('/get-streams',[StreamsController::class,'getStreams']);

// Add screenshots API\
Route::post('/Add_project_screenshots',[ProjectScreenshotsController::class,'addProjectScreenshot']);

// Update total time with in 1 minute screenshots API\
Route::post('/updateTimeAfterOneMinute',[ProjectScreenshotsController::class,'updateTimeAfterOneMinute']);

// get screenshots API\
Route::get('/get_Project_Screenshots',[ProjectScreenshotsController::class,'getProjectScreenshots']);

// get users by company id API\
Route::get('/get_company_by_company_id/{id}',[CompanyController::class,'get_company_by_company_id']);

//get screenshots by date
Route::get('/get_projectscreenshot_by_date/{date1}/{user_id}',[ProjectScreenshotsController::class,'getProjectScreenshotsByDate']);

//get screenshots by date and company_id
Route::get('/get_projectscreenshot_by_compny_id/{date1}/{company_id}',[ProjectScreenshotsController::class,'getProjectScreenshotsByDateWithCompanyId']);

// Add FSF API\
Route::post('/addFunctionalSpecificationForm',[FunctionalSpecificationFormController::class,'addFunctionalSpecificationForm']);

// Add FSF Has output Parameters API\
Route::post('/addFsfOutputParameters',[FunctionalSpecificationFormController::class,'addFsfOutputParameters']);

// Add FSF Has Input Parameters API\
Route::post('/addFsfHasInputParameters',[FunctionalSpecificationFormController::class,'addFsfHasInputParameters']);

// Update FSF API\
Route::post('/updateFunctionalSpecificationForm',[FunctionalSpecificationFormController::class,'updateFunctionalSpecificationForm']);

// Delete FSF API\
Route::post('/deleteFunctionalSpecificationForm',[FunctionalSpecificationFormController::class,'deleteFunctionalSpecificationForm']);

// get All FSF API\
Route::get('/getFunctionalSpecificationForm',[FunctionalSpecificationFormController::class,'getFunctionalSpecificationForm']);

// get FSF By Id API\
Route::get('/getFunctionalSpecificationFormById/{fsf}',[FunctionalSpecificationFormController::class,'getFunctionalSpecificationFormById']);

// get FSF By Fsf_Id API\
Route::get('/getFsfHasParameterByFsfId/{fsf_id}',[FunctionalSpecificationFormController::class,'getFsfHasParameterByFsfId']);

// Delete FSF By Fsf_Id API\
Route::post('/DeleteFsfHasParameterByFsfId',[FunctionalSpecificationFormController::class,'DeleteFsfHasParameterByFsfId']);

// Delete FSF has output parameters by Fsf_Id API\
Route::post('/DeleteFsfHasOutputParameterByFsfId/{id}',[FunctionalSpecificationFormController::class,'DeleteFsfHasOutputParameterByFsfId']);

//update FSF has input papameters By Fsf_Id API\
Route::post('/UpdateFsfHasInputParameterByFsfId',[FunctionalSpecificationFormController::class,'UpdateFsfHasInputParameterByFsfId']);

//get All Fsf Has Output Parameters
Route::get('/getFsfHasOutputParameters/{id}',[FunctionalSpecificationFormController::class,'getFsfHasOutputParameters']);

//get Fsf Has Output Parameters by id
Route::get('/getFsfHasOutputParameterById/{id}',[FunctionalSpecificationFormController::class,'getFsfHasOutputParameterById']);

// Delete FSF By Fsf_Id API\
Route::post('/UpdateFsfHasOutputParameterByFsfId',[FunctionalSpecificationFormController::class,'UpdateFsfHasOutputParameterByFsfId']);

// get FSF has output papameters By Fsf_Id API\
Route::get('/getFsfHasParameterById/{id}',[FunctionalSpecificationFormController::class,'getFsfHasParameterById']);

//get team lead by company Id
Route::get('/getTeamLeadByCompanyId/{company_id}',[TeamController::class,'getTeamLeadByCompanyId']);

// fsf assign by users\
Route::post('/fsfAssignToUsers',[FunctionalSpecificationFormController::class,'fsfAssignToUsers']);

//get Fsf Assign to users
Route::get('/getFsfAssignToUsersByFsfId/{fsf_id}',[FunctionalSpecificationFormController::class,'getFsfAssignToUsersByFsfId']);

//get sum of hours, minuts and seconds  
Route::get('/getSumByDateWithUserId/{date1}/{userId}',[ProjectScreenshotsController::class,'sumByDateWithUserId']);

//get sum of hours, minuts and seconds  
Route::get('/getSumByDatesWithUserId/{date1}/{date2}/{userId}',[ProjectScreenshotsController::class,'sumByDatesWithUserId']);

//get all Tasks 
Route::get('/getTasks',[TaskManagementController::class,'getTasks']);

//get task by id
Route::get('/getTaskById/{id}',[TaskManagementController::class,'getTaskById']);

// update task by id
Route::post('/updateTasks',[TaskManagementController::class,'updateTasks']);

//get Fsf Assign to users by fsf id
Route::get('/getFsfFromAssignToteamleadByFsfIdAndLogin/{fsf_id}',[FunctionalSpecificationFormController::class,'getFsfFromAssignToteamleadByFsfIdAndLogin']);

// delete task by id
Route::post('/deleteTaskById',[TaskManagementController::class,'deleteTaskById']);

// update task by user side
Route::post('/updateStatusByUserTask',[TaskManagementController::class,'updateStatusByUserTask']);

//get All Modules
Route::get('/getModules',[FunctionalSpecificationFormController::class,'getModules']);

// calculating weekly worked and time
Route::get('/calculateWeeklyActivity/{userId}',[ProjectScreenshotsController::class,'calculateWeeklyActivity']);

// calculating Daily worked and time
Route::get('/calculateDailyActivity/{userId}',[ProjectScreenshotsController::class,'calculateDailyActivity']);

// calculating monthly worked and time
Route::get('/calculateMonthlyActivity/{userId}',[ProjectScreenshotsController::class,'calculateMonthlyActivity']);

// calculating over all worked and time
Route::get('/calculateOverAllActivity/{userId}',[ProjectScreenshotsController::class,'calculateOverAllActivity']);

// devlopment Logic into Fsf Form
Route::post('/addDevelopmentLogicIntoFsfForm',[FunctionalSpecificationFormController::class,'addDevelopmentLogicIntoFsfForm']);

// Add input screen into Fsf Form
Route::post('/addInputScreen/{id}',[FunctionalSpecificationFormController::class,'addInputScreen']);

// Add output screen into Fsf Form
Route::post('/addOutputScreen/{id}',[FunctionalSpecificationFormController::class,'addOutputScreen']);

//get task by user id
Route::get('/getTaskByUserId/{userId}',[TaskManagementController::class,'getTaskByUserId']);

//get task by project id
Route::get('/getTaskByProjectId/{projectId}',[TaskManagementController::class,'getTaskByProjectId']);

//get task by project id and user id
Route::get('/getTaskByUserIdAndProjectId/{userId}/{projectId}',[TaskManagementController::class,'getTaskByUserIdAndProjectId']);

// add subscription 
Route::post('/addSubscription',[SubscriptionController::class,'addSubscription']);

// update subscription
Route::post('/updateSubscription/{id}',[SubscriptionController::class,'updateSubscription']);

// delete subscription
Route::post('/deleteSubscription/{id}',[SubscriptionController::class,'deleteSubscription']);

// //get All subscription
Route::get('/getAllSubscription',[SubscriptionController::class,'getAllSubscription']);

// add subscription invoice
Route::post('/addSubscriptionInvoice',[SubscriptionController::class,'addSubscriptionInvoice']);

// update subscription invoice
Route::post('/updateSubscriptionInvoice/{id}',[SubscriptionController::class,'updateSubscriptionInvoice']);

// delete subscription invoice
Route::post('/deleteSubscriptionInvoice/{id}',[SubscriptionController::class,'deleteSubscriptionInvoice']);

// //get All subscription invoice
Route::get('/getAllSubscriptionInvoice',[SubscriptionController::class,'getAllSubscriptionInvoice']);

// Add Request Change Form
Route::post('/addChangeRequestForm',[ChangeRequestFormcontroller::class,'addChangeRequestForm']);

// get Change Request Form
Route::get('/getChangeRequestForm',[ChangeRequestFormcontroller::class,'getChangeRequestForm']);

// get Change Request Form By Id
Route::get('/getChangeRequestFormById',[ChangeRequestFormcontroller::class,'getChangeRequestFormById']);

// update Change Request Form
Route::post('/updateChangeRequestForm',[ChangeRequestFormcontroller::class,'updateChangeRequestForm']);

// delete Change Request Form
Route::post('/deleteChangeRequestForm',[ChangeRequestFormcontroller::class,'deleteChangeRequestForm']);