<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ScreenShotsController;
use App\Http\Controllers\DepartmentController;

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

//Add department API
Route::post('/add_department',[DepartmentController::class,'add_department']);

//update department API
Route::post('/update-department',[DepartmentController::class,'update_department']);

//delete department API
Route::post('/delete-department',[DepartmentController::class,'delete_department']);

//Get department API
Route::get('/getdepartment',[DepartmentController::class,'get_department']);