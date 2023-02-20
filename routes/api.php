<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

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