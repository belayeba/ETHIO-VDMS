<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\tempController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\Vehicle\VehicleParmanentlyRequestController;
use App\Http\Controllers\vehicle\VehicleTemporaryRequestController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () 
{
    return view('templates.index');
});




// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();

Route::group(['middleware' => ['auth']], function()
{

        Route::resource('roles', RoleController::class);
        Route::get('/logout', 'LoginController@logout')->name('logout.logout');

    // Vehicle Temprory Request
Route::controller(VehicleTemporaryRequestController::class)->group(function()
    {
        Route::get('/temp_request_page', 'displayRequestPage');
        Route::post('/user_post_request', 'RequestVehicleTemp');
        Route::post('/user_delete_request', 'deleteRequest');
        Route::post('/user_update_info', 'update');
        Route::get('/director_approve_page', 'DirectorApprovalPage');
        Route::post('/director_approve_request', 'DirectorApproveRequest');
        Route::post('/director_reject_request', 'DirectorApproveRequest');
        Route::get('/simirit_approve_page', 'VehicleDirector');
        Route::post('/simirit_approve_request', 'VehicleDirectorApproveRequest');
        Route::post('/simirit_fill_start_km', ' VehicleDirectorFillstartKm');
        Route::post('/simirit_reject_request', 'VehicleDirectorRejectRequest');
        Route::post('/simirit_returns_vehicle', 'Returning_temporary_vehicle');
    });

Route::controller(usercontroller::class)->group(function()
{
    Route::get('/users', 'list')->name('user_list');
    Route::get('/users/list', 'list_show')->name('users.list.show');
    Route::get('/users/create','create')->name('user_create');
    Route::get('/users/store', 'store')->name('users.store');
});


// Vehicle Temprory Request
Route::controller(VehicleTemporaryRequestController::class)->group(function()
{
    Route::get('/temp_request_page', 'displayRequestPage')->name('displayRequestPage');
    Route::post('/user_post_request', 'RequestVehiclePerm');
    Route::post('/user_delete_request', 'deleteRequest');
    Route::post('/user_update_info', 'update');
    Route::get('/director_approve_page', 'DirectorApprovalPage');
    Route::post('/director_approve_request', 'DirectorApproveRequest');
    Route::post('/director_reject_request', 'DirectorApproveRequest');
    Route::get('/simirit_approve_page', 'VehicleDirector');
    Route::post('/simirit_approve_request', 'VehicleDirectorApproveRequest');
    Route::post('/simirit_fill_start_km', ' VehicleDirectorFillstartKm');
    Route::post('/simirit_reject_request', 'VehicleDirectorRejectRequest');
    Route::post('/simirit_returns_vehicle', 'Returning_temporary_vehicle');
});

Route::controller(LoginController::class)->group(function()
    {
        Route::post('/login_manual', 'authenticate')->name('login_manual');
    });

Route::controller(tempController::class)->group(function()
{
    Route::group(['middleware' => ['can:edit posts']], function () {
        // Routes accessible only to users with the 'create user' permission
        Route::get('/temp1', 'temp1');
        Route::get('/temp2', 'temp2');
    });
    
    Route::get('/temp3', 'temp3')->middleware('can:create posts');
    Route::get('/temp4', 'temp4');
    Route::get('/temp5', 'temp5');
    Route::get('/temp6', 'temp6');
    Route::get('/temp7', 'temp7');
    Route::get('/temp8', 'temp8');
    Route::get('/temp9', 'temp9');
    Route::get('/temp10', 'temp10');
    Route::get('/temp11', 'temp11');
    Route::get('/temp12', 'temp12');
    Route::get('/temp13', 'temp13');
    Route::get('/temp14', 'temp14');
    Route::get('/temp15', 'temp15');
    Route::get('/temp16', 'temp16');
    Route::get('/temp17', 'temp17');
    Route::get('/temp18', 'temp18');
    Route::get('/temp19', 'temp19');
    Route::get('/temp20', 'temp20');
    Route::get('/temp21', 'temp21');
    Route::get('/temp22', 'temp22');
    Route::get('/temp23', 'temp23');
    Route::get('/temp24', 'temp24');
    Route::get('/temp25', 'temp25');
    Route::get('/temp26', 'temp26');
    Route::get('/temp27', 'temp27');
    Route::get('/temp28', 'temp28');
    Route::group(['middleware' => ['role:admin']], function () {

        Route::get('/temp29', 'temp29');
    });
    
    Route::get('/temp30', 'temp30');
    Route::get('/temp31', 'temp31');
    Route::get('/temp32', 'temp32');
    Route::get('/temp33', 'temp33');
    Route::get('/temp34', 'temp34');
    Route::get('/temp35', 'temp35');
    Route::get('/temp36', 'temp36');
    Route::get('/temp37', 'temp37');
    Route::get('/temp38', 'temp38');
    Route::get('/temp39', 'temp39');
    Route::get('/temp40', 'temp40');
    Route::get('/temp41', 'temp41');
    Route::get('/temp42', 'temp42');
    Route::get('/temp43', 'temp43');
    Route::get('/temp44', 'temp44');
    Route::get('/temp45', 'temp45');
    Route::get('/temp46', 'temp46');
    Route::get('/temp47', 'temp47');
    Route::get('/temp48', 'temp48');
    Route::get('/temp49', 'temp49');
    Route::get('/temp50', 'temp50');
    Route::get('/temp51', 'temp51');
    Route::get('/temp52', 'temp52');
    Route::get('/temp53', 'temp53');
    Route::get('/temp54', 'temp54');
    Route::get('/temp55', 'temp55');
    Route::get('/temp56', 'temp56');
    Route::get('/temp57', 'temp57');
    Route::get('/temp58', 'temp58');
    Route::get('/temp59', 'temp59');
    Route::get('/temp60', 'temp60');
    Route::get('/temp61', 'temp61');
    Route::get('/temp62', 'temp62');
    Route::get('/temp63', 'temp63');
    Route::get('/temp64', 'temp64');
    Route::get('/temp65', 'temp65');
    Route::get('/temp66', 'temp66');
    Route::get('/temp67', 'temp67');
    Route::get('/temp68', 'temp68');
    Route::get('/temp69', 'temp69');
    Route::get('/temp70', 'temp70');
    Route::get('/temp71', 'temp71');
    Route::get('/temp72', 'temp72');
    Route::get('/temp73', 'temp73');
    Route::get('/temp74', 'temp74');
    Route::get('/temp75', 'temp75');
    Route::get('/temp76', 'temp76');

});






    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    });
    Route::resource('clusters', ClusterController::class);

//departmests route
Route::resource('departments', DepartmentController::class);
