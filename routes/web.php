<?php

use App\Http\Controllers\Driver\DriverChangeController;
use App\Http\Controllers\Driver\DriverRegistrationController;
use App\Http\Controllers\Fuel\FeulController;
use App\Http\Controllers\Mentenance\MentenanceController;
use App\Http\Controllers\Organization\DepartmentController;
use App\Http\Controllers\Vehicle\Daily_KM_Calculation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\tempController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\Organization\ClusterController;
use App\Http\Controllers\Route\RouteController;
use App\Http\Controllers\Vehicle\DailyReportController;
use App\Http\Controllers\Vehicle\GivingBackPermanentVehicle;
use App\Http\Controllers\Vehicle\VehicleParmanentlyRequestController;
// use App\Http\Controllers\Organization\ClustersController;
use App\Http\Controllers\vehicle\VehicleTemporaryRequestController;
use App\Http\Controllers\Vehicle\VehicleRegistrationController as VehicleVehicleRegistrationController ;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Vehicle\InspectionController;
use App\Http\Controllers\Vehicle\VehiclePartsController;
use App\Http\Controllers\Vehicle\VehicleRegistrationController;
Route::get('/', function () 
{
    return view('templates.index');
});


Route::get('/tabletest', function()
{
    return view('tables');
});

Route::get('/datetest', function()
{
    return view('date');
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
                        Route::get('temp_request_page', 'displayRequestPage')->name('displayRequestPage');//->middleware('can:create postsTemporary Request Page');;
                        Route::get('temp_request_page/edit/{id}', 'editRequestPage')->name('editRequestPage');
                        Route::post('/user_post_request', 'RequestVehicleTemp')->name('temp_request_post');
                        Route::post('/user_delete_request', 'deleteRequest')->name('temp_delete_request');
                        Route::post('/user_update_info', 'update')->name('temp_update_request');
                        Route::get('/director_approve_page/check', 'DirectorApprovalPage')->name('director_temp');
                        Route::post('/director_approve_requesta', 'DirectorApproveRequest')->name('director_approve_request');
                        Route::post('/director_reject_request', 'DirectorRejectRequest')->name('director_reject_request');
                        Route::get('/clusterDirector_approve_page', 'clusterDirectorApprovalPage')->name('ClusterDirector_temp');
                        Route::post('/clusterDirector_approve_requesta', 'clusterDirectorApproveRequest')->name('ClusterDirector_approve_request');
                        Route::post('/clusterDirector_reject_request', 'cluster_DirectorRejectRequest')->name('ClusterDirector_reject_request');
                        Route::get('/HRclusterDirector_approve_page', 'HRclusterDirectorApprovalPage')->name('HRClusterDirector_temp');
                        Route::post('/HRclusterDirector_approve_requesta', 'HrclusterDirectorApproveRequest')->name('HRClusterDirector_approve_request');
                        Route::post('/HRclusterDirector_reject_request', 'Hrcluster_DirectorRejectRequest')->name('HRClusterDirector_reject_request');
                        Route::get('/TransportDirector_approve_page', 'TransportDirectorApprovalPage')->name('TransportDirector_temp');
                        Route::post('/TransportDirector_approve_requesta', 'TransportDirectorApproveRequest')->name('TransportDirector_approve_request');
                        Route::post('/TransportDirector_reject_request', 'TransportDirectorRejectRequest')->name('TransportDirector_reject_request');
                        Route::get('/simirit_approve_page', 'SimiritPage')->name('simirit_page');
                        Route::post('/simirit_approve_request', 'simiritApproveRequest')->name('simirit_approve');
                        Route::post('/simirit_fill_start_km', ' simiritFillstartKm')->name('simirit_fill_start_km');
                        Route::post('/simirit_reject_request', 'simiritRejectRequest')->name('simirit_reject');
                        Route::post('/simirit_returns_vehicle', 'Returning_temporary_vehicle')->name('simirit_return_vehicle');
                });
            Route::controller(MentenanceController::class)->group(function()
                {
                        Route::get('/mentaincance_request_page', 'displayMaintenanceRequestPage');
                        //Route::post('/user_post_request', 'RequestVehicleTemp')->name('temp_request_post');
                        // Route::post('/user_delete_request', 'deleteRequest')->name('temp_delete_request');
                        // Route::post('/user_update_info', 'update_temp_request')->name('temp_update_request');
                        // Route::get('/director_approve_page', 'DirectorApprovalPage')->name('director_approve_page');
                        // Route::post('/director_approve_request', 'DirectorApproveRequest')->name('director_approve_request');
                        // Route::post('/director_reject_request', 'DirectorApproveRequest')->name('director_reject_request');
                        // Route::get('/simirit_approve_page', 'VehicleDirector')->name('simirit_page');
                        // Route::post('/simirit_approve_request', 'VehicleDirectorApproveRequest')->name('simirit_approve');
                        // Route::post('/simirit_fill_start_km', ' VehicleDirectorFillstartKm')->name('simirit_fill_start_km');
                        // Route::post('/simirit_reject_request', 'VehicleDirectorRejectRequest')->name('simirit_reject');
                        // Route::post('/simirit_returns_vehicle', 'Returning_temporary_vehicle')->name('simirit_return_vehicle');
                });
            Route::controller(FeulController::class)->group(function()
                {
                        Route::get('/fuel_request_page', 'displayFuelRequestPage');
                        //Route::post('/user_post_request', 'RequestVehicleTemp')->name('temp_request_post');
                        // Route::post('/user_delete_request', 'deleteRequest')->name('temp_delete_request');
                        // Route::post('/user_update_info', 'update_temp_request')->name('temp_update_request');
                        // Route::get('/director_approve_page', 'DirectorApprovalPage')->name('director_approve_page');
                        // Route::post('/director_approve_request', 'DirectorApproveRequest')->name('director_approve_request');
                        // Route::post('/director_reject_request', 'DirectorApproveRequest')->name('director_reject_request');
                        // Route::get('/simirit_approve_page', 'VehicleDirector')->name('simirit_page');
                        // Route::post('/simirit_approve_request', 'VehicleDirectorApproveRequest')->name('simirit_approve');
                        // Route::post('/simirit_fill_start_km', ' VehicleDirectorFillstartKm')->name('simirit_fill_start_km');
                        // Route::post('/simirit_reject_request', 'VehicleDirectorRejectRequest')->name('simirit_reject');
                        // Route::post('/simirit_returns_vehicle', 'Returning_temporary_vehicle')->name('simirit_return_vehicle');
                });
            Route::controller(usercontroller::class)->group(function()
                {
                    Route::get('/users', 'list')->name('user_list');
                    Route::get('/users/list', 'list_show')->name('users.list.show');
                    Route::get('/users/create','create')->name('user_create');
                    Route::post('/users/store', 'store')->name('users.store');
                    Route::get('/update/{id}', 'update')->name('user.update');
                    Route::post('/updates/store','storeupdates')->name('user.update.store');
                });
                // Vehicle registration 
                Route::group([
                    'prefix'=>'vehicle',
                ], function (){
                Route::get('/',[VehicleVehicleRegistrationController::class, 'index'])->name('vehicleRegistration.index');
                Route::post('/store',[VehicleVehicleRegistrationController::class, 'store'])->name('vehicleRegistration.store');
                Route::delete('/delete/{vehicle}',[VehicleVehicleRegistrationController::class,'destroy'])->name('vehicle.destroy');
                Route::put('/update/{vehicle}', [VehicleVehicleRegistrationController::class, 'update'])->name('vehicle.update');
            
                });
            // Vehicle Permanent Request
            Route::controller(VehicleParmanentlyRequestController::class)->group(function()
                {
                    Route::get('/perm_request_page', 'displayPermRequestPage')->name('vec_perm_request');
                    Route::post('/perm_user_post_request', 'RequestVehiclePerm')->name('vec_perm_request_post');
                    Route::post('/Perm_user_delete_request', 'deleteRequest')->name('user_perm_delet');
                    Route::post('/perm_user_update_info', 'update_perm_request')->name('perm_vec_update');
                    Route::get('/director_approve_page/perm', 'DirectorApprovalPage')->name('perm_vec_director_page');
                    Route::post('/perm_director_approve_request', 'DirectorApproveRequest')->name('perm_vec_director_approve');
                    Route::post('/perm_director_reject_request', 'DirectorRejectRequest')->name('perm_vec_direct_reject');
                    Route::get('/perm_simirit_approve_page', 'Dispatcher_page')->name('perm_vec_simirit_page');
                    Route::post('/perm_simirit_approve_request', 'DispatcherApproveRequest')->name('perm_vec_simirit_approve');
                    Route::post('/perm_simirit_reject_request', 'DispatcherRejectRequest')->name('perm_vec_simirit_reject');
                });
            Route::controller(GivingBackPermanentVehicle::class)->group(function () 
                {
                    Route::get('/return-permanent-request-page', 'displayReturnPermRequestPage')->name('return_permanent_request_page');
                    Route::post('/return-vehicle-permanent', 'ReturntVehiclePerm')->name('return_vehicle_permanent');
                    Route::put('/update-return-request', 'update_return_request')->name('update_return_request');
                    Route::delete('/delete-request', 'deleteRequest')->name('delete_request');
                    Route::get('/director-approval-page', 'DirectorApprovalPage')->name('director_approval_page');
                    Route::post('/director-approve-request', 'DirectorApproveRequest')->name('director_approve_givingback_request');
                    Route::post('/director-reject-request', 'DirectorRejectRequest')->name('director_reject_request');
                    Route::get('/vehicle-director-page', 'VehicleDirector_page')->name('vehicle_director_page');
                    Route::post('/vehicle-director-approve-request', 'VehicleDirectorApproveRequest')->name('vehicle_director_approve_request');
                    Route::post('/vehicle-director-reject-request', 'VehicleDirectorRejectRequest')->name('vehicle_director_reject_request');
                });
                //Report Tinsae
            Route::controller(DailyReportController::class)->group(function () 
                {
                    // Route::post('/return-vehicle-permanent', 'ReturntVehiclePerm')->name('return_vehicle_permanent');
                    // Route::put('/update-return-request', 'update_return_request')->name('update_return_request');
                    // Route::delete('/delete-request', 'deleteRequest')->name('delete_request');
                    // Route::get('/director-approval-page', 'DirectorApprovalPage')->name('director_approval_page');
                    // Route::post('/director-approve-request', 'DirectorApproveRequest')->name('director_approve_request');
                    // Route::post('/director-reject-request', 'DirectorRejectRequest')->name('director_reject_request');
                    // Route::get('/vehicle-director-page', 'VehicleDirector_page')->name('vehicle_director_page');
                    // Route::post('/vehicle-director-approve-request', 'VehicleDirectorApproveRequest')->name('vehicle_director_approve_request');
                    // Route::post('/vehicle-director-reject-request', 'VehicleDirectorRejectRequest')->name('vehicle_director_reject_request');
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
                 // Define routes for daily_km
            Route::controller(Daily_KM_Calculation::class)->group(function ()
                {
                Route::get('/daily','ReportPage')->name('dailyreport.index');
                Route::get('/daily_km/check', 'CheckVehicle')->name('daily_km.page.check');
                Route::post('/daily_km/store', 'displayForm')->name('daily_km.page.store'); // Create a new inspection
                Route::post('/daily_km/morning', 'morning_km')->name('daily_km.page.morning'); // Show a specific inspection
                Route::post('/daily_km/afternoon', 'aftern_km')->name('daily_km.page.evening'); // List all inspections
                Route::get('/daily_km/page', 'displayPage')->name('daily_km.page'); // inspection page
                Route::delete('/daily_km/delete', 'delete_morningkm')->name('daily_km.page.delete'); // Delete a specific inspection
                });
            // Samir Driver Registration
            Route::group([
                'prefix'=>'driver',
            ], function ()
                {
                    Route::get('/',[DriverRegistrationController::class, 'RegistrationPage'])->name('driver.index');
                    Route::post('/store',[DriverRegistrationController::class, 'store'])->name('driver.store');
                    Route::delete('/delete/{driver}',[DriverRegistrationController::class,'destroy'])->name('driver.destroy');
                    Route::put('/update/{driver}', [DriverRegistrationController::class, 'update'])->name('driver.update');
                });
                Route::group([
                    'prefix'=>'driver_change',
                ], function (){
                Route::get('/',[DriverChangeController::class, 'driver_change_page'])->name('driver.switch');
                Route::post('/store',[DriverChangeController::class, 'store'])->name('driver_change.store');
                Route::put('/update/{request_id}', [DriverChangeController::class, 'update'])->name('driverchange.update');
                Route::delete('/delete/{request_id}', [DriverChangeController::class, 'destroy'])->name('driverchange.destroy');

                });

                Route::group([
                    'prefix'=>'Route',
                ], function (){
                Route::get('/',[RouteController::class, 'displayAllRoutes'])->name('route.index');
                Route::get('/user',[RouteController::class, 'displayRoute'])->name('route.show');
                Route::post('/store',[RouteController::class, 'registerRoute'])->name('route.store');
                Route::post('/employee/store',[RouteController::class, 'assignUsersToRoute'])->name('employeeService.store');
                Route::put('/update/{request_id}', [RouteController::class, 'update'])->name('route.update');
                Route::delete('/delete/{request_id}', [RouteController::class, 'removeRoute'])->name('route.destroy');

                });
                // Define routes for InspectionController
            Route::controller(InspectionController::class)->group(function ()
                 {
                    Route::post('/inspection/store', 'storeInspection')->name('inspection.store'); // Create a new inspection
                    Route::get('/inspection/{inspectionId}', 'showInspection')->name('inspection.show'); // Show a specific inspection
                    Route::get('/get_photo', 'send_photo_data')->name('inspection.ByVehicle'); // Show a specific inspection
                    Route::get('/inspections', 'listInspections')->name('inspection.list'); // List all inspections
                    Route::get('/inspections/page', 'InspectionPage')->name('inspection.page'); // inspection page
                    Route::get('/inspect_vehicle/{id}', 'showInspectionbyVehicle');//->name('inspection.ByVehicle'); // inspection page
                    Route::put('/inspection/{inspectionId}/{partName}', 'updateInspection')->name('inspection.update'); // Update a specific inspection
                    Route::delete('/inspection/{inspectionId}', 'deleteInspection')->name('inspection.delete'); // Delete a specific inspection
                 });
                 // SAMIR
                 Route::group([
                    'prefix'=>'vehicle',
                ], function (){
                Route::get('/',[VehicleRegistrationController::class, 'index'])->name('vehicleRegistration.index');
                Route::post('/store',[VehicleRegistrationController::class, 'store'])->name('vehicleRegistration.store');
                Route::delete('/delete/{vehicle}',[VehicleRegistrationController::class,'destroy'])->name('vehicle.destroy');
                Route::put('/update/{vehicle}', [VehicleRegistrationController::class, 'update'])->name('vehicle.update');
            
                });
            // Route::controller(VehicleRegistrationController::class)->group(function () 
            //     {
            //          Route::get('/xx', 'index')->name('vehicleRegistration.index'); 
            //          Route::post('/store', 'store')->name('vehicle.store'); 
            //          Route::delete('/delete/{vehicle}', 'destroy')->name('vehicle.destroy'); 
            //          Route::put('/update/{vehicle}', 'update')->name('vehicle.update'); 
            //     });
                // Define routes for VehiclePartsController
            Route::controller(VehiclePartsController::class)->group(function () 
                {
                     Route::post('/vehicle-parts', 'store')->name('vehicle_parts.store'); // Create a new vehicle part
                     Route::get('/vehicle-parts-show/{id}', 'show')->name('vehicle_parts.show'); // Retrieve a specific vehicle part
                     Route::get('/vehicle-parts', 'index')->name('vehicle_parts.index'); // List all vehicle parts
                     Route::post('/vehicle-parts-update/{id}', 'update')->name('vehicle_parts.update'); // Update a vehicle part
                     Route::delete('/vehicle-parts-delete/{id}', 'destroy')->name('vehicle_parts.destroy'); // Delete a vehicle part
                });
                 
            Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');           

    Route::group([
        'prefix'=>'cluster',
    ], function (){
    Route::get('/',[ClusterController::class,'index'])->name('cluster.index');
    Route::get('/create',[ClusterController::class,'create'])->name('cluster.create');
    Route::post('/store', [ClusterController::class,'store'])->name('cluster.store');
    Route::post('/{cluster}/update', [ClusterController::class,'update'])->name('cluster.update');
    Route::get('/view',[ClusterController::class,'show'])->name('cluster.show');
    Route::delete('/delete/{cluster}',[ClusterController::class,'destroy'])->name('cluster.destroy');
    });
    Route::group([
        'prefix'=>'department',
    ], function (){
        Route::get('/',[DepartmentController::class,'index'])->name('department.index');
        // Route::get('/create',[DepartmentController::class,'create'])->name('department.create');
        Route::post('/store',[DepartmentController::class,'store'])->name('department.store');
        Route::post('/{department}/update', [DepartmentController::class,'update'])->name('department.update');
        Route::delete('/delete/{department}',[DepartmentController::class,'destroy'])->name('department.destroy');
    });

    // Tinsae
});