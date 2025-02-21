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
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Vehicle\DailyReportController;
use App\Http\Controllers\Vehicle\FeulCostController;
use App\Http\Controllers\Vehicle\Fuel_QuataController;
use App\Http\Controllers\Vehicle\GivingBackPermanentVehicle;
use App\Http\Controllers\Vehicle\VehicleParmanentlyRequestController;
// use App\Http\Controllers\Organization\ClustersController;
use App\Http\Controllers\Vehicle\VehicleTemporaryRequestController;
use App\Http\Controllers\Vehicle\VehicleRegistrationController as VehicleVehicleRegistrationController;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Vehicle\InspectionController;
use App\Http\Controllers\Vehicle\VehiclePartsController;
use App\Http\Controllers\Vehicle\VehicleRegistrationController;
use App\Http\Controllers\Vehicle\PermanentFuelController;
use App\Http\Controllers\Vehicle\AttendanceController;
use App\Http\Controllers\Vehicle\ReplacementController;
use App\Http\Controllers\Letter\LetterController;
use App\Http\Controllers\Letter\LetterManagement;
use App\Http\Controllers\localeController;
use App\Http\Controllers\Route\EmployeeChangeLocationController;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home'); 
    }

    return view('auth.login');
});

Route::controller(usercontroller::class)->withoutMiddleware([ValidateCsrfToken::class])->group(function () {
    Route::post('/key_clocklogin', 'login');
});
Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::resource('roles', RoleController::class);
    Route::get('/logout', 'LoginController@logout')->name('logout.logout');

    // Vehicle Temprory Request
    Route::controller(VehicleTemporaryRequestController::class)->group(function () {
        Route::get('temp_request_page', 'displayRequestPage')->name('displayRequestPage')->middleware('can:Temporary Request Page');
        Route::get('fetch_temp_request_page', 'FetchTemporaryRequest')->name('FetchTemporaryRequest');
        Route::get('temp_request_page/edit/{id}', 'editRequestPage')->name('editRequestPage')->middleware('can:Temporary Request Page');
        Route::post('/user_post_request', 'RequestVehicleTemp')->name('temp_request_post')->middleware('can:Temporary Request Page');
        Route::post('/user_delete_request', 'deleteRequest')->name('temp_delete_request')->middleware('can:Temporary Request Page');
        Route::post('/user_update_info', 'update')->name('temp_update_request')->middleware('can:Temporary Request Page');
        Route::get('/director_approve_page/Temp', 'DirectorApprovalPage')->name('director_temp')->middleware('can:Director Approval Page');
        Route::get('/fetch_director_page/perm', 'FetchForDirector')->name('FetchForDirector');
        Route::post('/director_approve_requesta', 'DirectorApproveRequest')->name('director_approve_request')->middleware('can:Director Approval Page');
        Route::post('/director_reject_request', 'DirectorRejectRequest')->name('director_reject_request')->middleware('can:Director Approval Page');
        Route::get('/clusterDirector_approve_page', 'clusterDirectorApprovalPage')->name('ClusterDirector_temp')->middleware('can:Clustor Director Apporal Page');
        Route::post('/clusterDirector_approve_requesta', 'clusterDirectorApproveRequest')->name('ClusterDirector_approve_request')->middleware('can:Clustor Director Apporal Page');
        Route::post('/clusterDirector_reject_request', 'cluster_DirectorRejectRequest')->name('ClusterDirector_reject_request')->middleware('can:Clustor Director Apporal Page');
        Route::get('/HRclusterDirector_approve_page', 'HRclusterDirectorApprovalPage')->name('HRClusterDirector_temp')->middleware('can:HR Cluster Director Approval Page');
        Route::post('/HRclusterDirector_approve_requesta', 'HrclusterDirectorApproveRequest')->name('HRClusterDirector_approve_request')->middleware('can:HR Cluster Director Approval Page');
        Route::post('/HRclusterDirector_reject_request', 'Hrcluster_DirectorRejectRequest')->name('HRClusterDirector_reject_request')->middleware('can:HR Cluster Director Approval Page');
        Route::get('/TransportDirector_approve_page', 'TransportDirectorApprovalPage')->name('TransportDirector_temp')->middleware('can:Transport Director');
        Route::post('/TransportDirector_approve_requesta', 'TransportDirectorApproveRequest')->name('TransportDirector_approve_request')->middleware('can:Transport Director');
        Route::post('/TransportDirector_reject_request', 'TransportDirectorRejectRequest')->name('TransportDirector_reject_request')->middleware('can:Transport Director');
        Route::get('/simirit_approve_page', 'SimiritPage')->name('simirit_page')->middleware('can:Dispatcher Page');
        Route::get('/FetchForDispatchery/temp', 'FetchForDispatcher')->name('FetchForDispatcher')->middleware('can:Dispatcher Page');
        Route::post('/temp_simirit_approve_request', 'simiritApproveRequest')->name('simirit_approve_temporary')->middleware('can:Dispatcher Page');
        Route::post('/simirit_fill_start_km/store', 'simiritFillstartKm')->name('simirit_fill_start_km')->middleware('can:Dispatcher Page');
        Route::post('/simirit_reject_request', 'simiritRejectRequest')->name('simirit_reject')->middleware('can:Dispatcher Page');
        Route::post('/simirit_returns_vehicle', 'Returning_temporary_vehicle')->name('simirit_return_vehicle')->middleware('can:Dispatcher Page');
    });

    Route::controller(MentenanceController::class)->group(function () {
        Route::get('/mentaincance_request_page', 'displayMaintenanceRequestPage')->name('maintenance_request');
        Route::post('/driver_post_request', 'RequestMaintenance')->name('driver_request_post');
        Route::get('/fetchMaintenance_request', 'fetchMaintenanceRequest')->name('FetchMaintenanceRequest');
        Route::get('/show_approver_request', 'displayRequestForApprover')->name('maintenance_approver');
        Route::post('/approver_approve_request', 'approver_approval')->name('approver_approve_request');
        Route::get('/show_maintenance_inspector', 'displayRequestForInspection')->name('maintenance_inspection');
        Route::post('/approver_rejection', 'approver_rejection')->name('approver_rejection');
        Route::post('/inspector_approve', 'inspector_approve')->name('inspector_inspection');
        Route::get('/show_simirit_request', 'displayRequestForSimirit')->name('simirit_display');
        Route::get('/show_Maintenance_final', 'displayMaintenanceFinal')->name('Final_display');
        Route::post('/maintenance_simirit_approve_request', 'simirit_approval')->name('simirit_approve_request');
        Route::post('/simirit_reject', 'simirit_rejection')->name('simirit_rejection');
        Route::post('/end_maintenance', 'end_maintenance')->name('end_maintenance');
        Route::post('/user_delete_request', 'deleteRequest')->name('temp_delete_request');
    });

    Route::controller(PermanentFuelController::class)->group(function () {
        Route::get('/permanent_fuel_request_page', 'index')->name('permanenet_fuel_request')->middleware('can:Request Fuel');
        Route::get('/perm_fuel_page_fetch', 'fuel_request_fetch')->name('perm_fuel_page_fetch')->middleware('can:Request Fuel');
        Route::post('/fuel_post_request', 'store')->name('store_fuel_request')->middleware('can:Request Fuel');
        Route::post('/update_entries', 'update')->name('update_entries')->middleware('can:Request Fuel');
        Route::post('/attach_new_reciet', 'attach_new_reciet')->name('attach_new_reciet')->middleware('can:Request Fuel');
        Route::get('/finance_approve_page', 'finance_get_page')->name('finance_approve_fuel_page')->middleware('can:Finance Accept');
        Route::get('/finance_page_fetch', 'finance_fetch')->name('finance_page_fetch')->middleware('can:Finance Accept');
        Route::post('/get_each_cost', 'getPreviousCost')->name('get_each_cost')->middleware('can:Finance Accept');
        Route::get('/finance_appprove/{id}', 'finance_approve')->name('finance_approve')->middleware('can:Finance Accept');
        Route::get('/show_detail/{id}', 'show');
        Route::get('/get_my_request', 'my_request')->name('my_request');
        Route::post('/reject_request/{id}', 'finance_reject')->name('finance_reject')->middleware('can:Finance Accept');
    });
    Route::controller(usercontroller::class)->group(function () {
        Route::get('/search-users', 'searchUsers')->name('search.users');
        Route::get('/users', 'list')->name('user_list')->middleware('can:Create User');
        Route::get('/users/list', 'list_show')->name('users.list.show')->middleware('can:Create User');
        Route::get('/users/create', 'create')->name('user_create')->middleware('can:Create User');
        Route::post('/users/store', 'store')->name('users.store')->middleware('can:Create User');
        Route::get('/update/{id}', 'update')->name('user.update')->middleware('can:Create User');
        Route::post('/updates/store', 'storeupdates')->name('user.update.store')->middleware('can:Create User');
        Route::post('/user/import', 'importUserExcel')->name('users.import')->middleware('can:Create User');
        Route::post('/user/delete', 'destroy')->name('users.delete')->middleware('can:Create User');
        Route::get('/profile', 'profile')->name('user_profile');
        Route::get('/user/export', 'exportToPdf')->name('user_export')->middleware('can:Create User');
        Route::post('/profile/store', 'profile_save')->name('user.profile.store');
    });
    //     // Vehicle registration 
    Route::group([
        'prefix' => 'vehicle',
        ], function () {
            Route::get('/', [VehicleVehicleRegistrationController::class, 'index'])->name('vehicleRegistration.index')->middleware('can:Vehicle Registration');
            Route::post('/store', [VehicleVehicleRegistrationController::class, 'store'])->name('vehicleRegistration.store')->middleware('can:Vehicle Registration');
            Route::delete('/delete/{vehicle}', [VehicleVehicleRegistrationController::class, 'destroy'])->name('vehicle.destroy')->middleware('can:Vehicle Registration');
            Route::put('/update/{vehicle}', [VehicleVehicleRegistrationController::class, 'update'])->name('vehicle.update')->middleware('can:Vehicle Registration');
            Route::get('/list', [VehicleVehicleRegistrationController::class, 'list'])->name('vehicle.list')->middleware('can:Vehicle Registration');
            Route::post('/update-status', [VehicleVehicleRegistrationController::class, 'updateStatus'])->name('vehicle.status')->middleware('can:Vehicle Registration');
    });
    // Route::put('/vehicles/{id}/status', [VehicleVehicleRegistrationController::class, 'updateStatus']);

    // Vehicle Permanent Request
    Route::controller(VehicleParmanentlyRequestController::class)->group(function () {
        Route::get('/perm_request_page', 'displayPermRequestPage')->name('vec_perm_request')->middleware('can:Permanent Request Page');
        Route::get('fetch_permanent_request', 'FetchPermanentRequest')->name('FetchPermanentRequest');
        Route::post('/perm_user_post_request', 'RequestVehiclePerm')->name('vec_perm_request_post')->middleware('can:Permanent Request Page');
        Route::post('/Perm_user_delete_request', 'deleteRequest')->name('user_perm_delet')->middleware('can:Permanent Request Page');
        Route::post('/perm_user_update_info', 'update_perm_request')->name('perm_vec_update')->middleware('can:Permanent Request Page');
        Route::get('/director_approve_page/perm', 'DirectorApprovalPage')->name('perm_vec_director_page')->middleware('can:Vehicle Director Page');
        Route::get('fetch_permanent_request_director', 'FetchForPermanenetDirector')->name('FetchForPermanenetDirector')->middleware('can:Vehicle Director Page');
        Route::post('/perm_director_approve_request', 'DirectorApproveRequest')->name('perm_vec_director_approve')->middleware('can:Vehicle Director Page');
        Route::post('/perm_director_reject_request', 'DirectorRejectRequest')->name('perm_vec_direct_reject')->middleware('can:Vehicle Director Page');
        Route::get('/perm_simirit_approve_page', 'Dispatcher_page')->name('perm_vec_simirit_page')->middleware('can:Dispatcher');
        Route::get('/FetchPermanentForDispatcher', 'FetchPermanentForDispatcher')->name('FetchPermanentForDispatcher')->middleware('can:Dispatcher');
        Route::post('/perm_simirit_approve_request', 'DispatcherApproveRequest')->name('perm_vec_simirit_approve')->middleware('can:Dispatcher');
        Route::post('/perm_simirit_reject_request', 'DispatcherRejectRequest')->name('perm_vec_simirit_reject')->middleware('can:Dispatcher');
        Route::get('/user_accept_assigned_vehicle/{id}', 'accept_assigned_vehicle')->name('accept_assigned_vehicle')->middleware('can:Permanent Request Page');
        Route::post('/user_decline_assigned_vehicle', 'reject_assigned_vehicle')->name('reject_assigned_vehicle')->middleware('can:Permanent Request Page');
    });
    Route::controller(GivingBackPermanentVehicle::class)->group(function () {
        Route::get('/return-permanent-request-page', 'displayReturnPermRequestPage')->name('return_permanent_request_page')->middleware('can:Request Return');
        Route::post('/return-vehicle-permanent', 'ReturntVehiclePerm')->name('return_vehicle_permanent')->middleware('can:Request Return');
        Route::put('/update-return-request', 'update_return_request')->name('update_return_request')->middleware('can:Request Return');
        Route::delete('/delete-request', 'deleteRequest')->name('delete_request')->middleware('can:Request Return');
        Route::get('/director-approval-page', 'VehicleDirector_page')->name('director_approval_page')->middleware('can:Approve Return');
        Route::get('/director-fetch-return', 'FetchReturnDirector')->name('FetchReturnDirector');
        Route::post('/director-approve-request', 'VehicleDirectorApproveRequest')->name('director_approve_givingback_request')->middleware('can:Approve Return');
        Route::post('/director-reject-request', 'Vec_DirectorRejectRequest')->name('director_reject_requesting')->middleware('can:Approve Return');
        Route::get('/vehicle-director-page', 'Dispatcher_page')->name('vehicle_director_page')->middleware('can:Take Back to Transport');
        Route::post('/vehicle-director-approve-request', 'DispatcherApproveRequest')->name('vehicle_director_approve_request')->middleware('can:Take Back to Transport');
        Route::post('/vehicle-director-reject-request', 'DispatcherRejectRequest')->name('vehicle_director_reject_request')->middleware('can:Take Back to Transport');
    });
   
    // Route::controller(tempController::class)->group(function () {
    //     Route::group(['middleware' => ['can:edit posts']], function () {
    //         // Routes accessible only to users with the 'create user' permission
    //         Route::get('/temp1', 'temp1');
    //         Route::get('/temp2', 'temp2');
    //     });

    //     Route::get('/temp3', 'temp3')->middleware('can:create posts');
    //     Route::get('/temp4', 'temp4');
    //     Route::get('/temp5', 'temp5');
    //     Route::get('/temp6', 'temp6');
    //     Route::get('/temp7', 'temp7');
    //     Route::get('/temp8', 'temp8');
    //     Route::get('/temp9', 'temp9');
    //     Route::get('/temp10', 'temp10');
    //     Route::get('/temp11', 'temp11');
    //     Route::get('/temp12', 'temp12');
    //     Route::get('/temp13', 'temp13');
    //     Route::get('/temp14', 'temp14');
    //     Route::get('/temp15', 'temp15');
    //     Route::get('/temp16', 'temp16');
    //     Route::get('/temp17', 'temp17');
    //     Route::get('/temp18', 'temp18');
    //     Route::get('/temp19', 'temp19');
    //     Route::get('/temp20', 'temp20');
    //     Route::get('/temp21', 'temp21');
    //     Route::get('/temp22', 'temp22');
    //     Route::get('/temp23', 'temp23');
    //     Route::get('/temp24', 'temp24');
    //     Route::get('/temp25', 'temp25');
    //     Route::get('/temp26', 'temp26');
    //     Route::get('/temp27', 'temp27');
    //     Route::get('/temp28', 'temp28');
    //     // Route::group(['middleware' => ['role:admin']], function () {

    //     Route::get('/temp29', 'temp29');
    //     // });
    //     Route::get('/temp30', 'temp30');
    //     Route::get('/temp31', 'temp31');
    //     Route::get('/temp32', 'temp32');
    //     Route::get('/temp33', 'temp33');
    //     Route::get('/temp34', 'temp34');
    //     Route::get('/temp35', 'temp35');
    //     Route::get('/temp36', 'temp36');
    //     Route::get('/temp37', 'temp37');
    //     Route::get('/temp38', 'temp38');
    //     Route::get('/temp39', 'temp39');
    //     Route::get('/temp40', 'temp40');
    //     Route::get('/temp41', 'temp41');
    //     Route::get('/temp42', 'temp42');
    //     Route::get('/temp43', 'temp43');
    //     Route::get('/temp44', 'temp44');
    //     Route::get('/temp45', 'temp45');
    //     Route::get('/temp46', 'temp46');
    //     Route::get('/temp47', 'temp47');
    //     Route::get('/temp48', 'temp48');
    //     Route::get('/temp49', 'temp49');
    //     Route::get('/temp50', 'temp50');
    //     Route::get('/temp51', 'temp51');
    //     Route::get('/temp52', 'temp52');
    //     Route::get('/temp53', 'temp53');
    //     Route::get('/temp54', 'temp54');
    //     Route::get('/temp55', 'temp55');
    //     Route::get('/temp56', 'temp56');
    //     Route::get('/temp57', 'temp57');
    //     Route::get('/temp58', 'temp58');
    //     Route::get('/temp59', 'temp59');
    //     Route::get('/temp60', 'temp60');
    //     Route::get('/temp61', 'temp61');
    //     Route::get('/temp62', 'temp62');
    //     Route::get('/temp63', 'temp63');
    //     Route::get('/temp64', 'temp64');
    //     Route::get('/temp65', 'temp65');
    //     Route::get('/temp66', 'temp66');
    //     Route::get('/temp67', 'temp67');
    //     Route::get('/temp68', 'temp68');
    //     Route::get('/temp69', 'temp69');
    //     Route::get('/temp70', 'temp70');
    //     Route::get('/temp71', 'temp71');
    //     Route::get('/temp72', 'temp72');

    //     Route::get('/temp73', 'temp73');
    //     Route::get('/temp74', 'temp74');
    //     Route::get('/temp75', 'temp75');
    //     Route::get('/temp76', 'temp76');
    // });
    // Define routes for daily_km
    Route::controller(Daily_KM_Calculation::class)->group(function () {
        Route::get('/daily', 'ReportPage')->name('dailyreport.index')->middleware('can:Daily KM Report');
        Route::get('/daily/fetchReport', 'FetchDailyReport')->name('FetchDailyReport')->middleware('can:Daily KM Report');
        Route::get('/vehicle/report/permanent', 'permanentReport')->name('dailyreport.permanentReport')->middleware('can:Permananet Vehicle Request');
        Route::get('/vehicle/report/temporary', 'temporaryReport')->name('dailyreport.temporaryReport')->middleware('can:Temporary Vehicle Request');

        Route::get('/vehicle/dailyreport/filter',  'filterReport')->name('dailyreport.filterReport')->middleware('can:Daily KM Report');
        Route::get('/vehicle/report/permanent/filter',  'filterPermanentReport')->name('dailyreport.filterPermanentReport')->middleware('can:Permananet Vehicle Request');
        Route::get('/vehicle/report/temporary/filter', 'filterTemporaryReport')->name('dailyreport.filterTemporaryReport')->middleware('can:Temporary Vehicle Request');
        Route::get('/daily_km/check', 'CheckVehicle')->name('daily_km.page.check');
        Route::post('/daily_km/store', 'displayForm')->name('daily_km.page.store'); // Create a new inspection
        Route::post('/daily_km/morning', 'morning_km')->name('daily_km.page.morning'); // Show a specific inspection
        Route::post('/daily_km/afternoon', 'aftern_km')->name('daily_km.page.evening'); // List all inspections
        Route::get('/daily_km/page', 'displayPage')->name('daily_km.page'); // inspection page
        Route::post('d_k/update', 'updateKm')->name('daily_km.page.update'); // Delete a specific inspection
    });
    Route::get('/daily/list', [Daily_KM_Calculation::class, 'list'])->name('tempreport.list');

    Route::get('/vehicle/report/data', [Daily_KM_Calculation::class, 'vehicleReport'])->name('dailyreport.vehicleReport');
    Route::get('/vehicle/report/filter', [Daily_KM_Calculation::class, 'filterVehicleReport'])->name('dailyreport.filterVehicleReport');

    Route::controller(Fuel_QuataController::class)->group(function () {
        Route::get('/get_all', 'index')->name('all_fuel_quota');
        Route::get('/get_one/{id}', 'show')->name('select_one');
        Route::post('/save_quota_change', 'store')->name('save_quota_change');
        Route::post('/save_update/{id}', 'update')->name('save_quota_update');
    });
    Route::controller(FeulCostController::class)->group(function () {
        Route::get('/get_all_feul_costs', 'index')->name('all_fuel_cost');
        Route::get('/get_one/{id}', 'show')->name('select_one');
        Route::post('/save_change', 'store')->name('save_cost_change');
    });

    Route::group([
        'prefix' => 'quota',
    ], function () {
        Route::get('/', [Fuel_QuataController::class, 'index'])->name('quota.index');
        Route::post('/store', [Fuel_QuataController::class, 'store'])->name('quota.store');
        Route::put('/update/{id}', [Fuel_QuataController::class, 'update'])->name('quota.update');
    });

    // Samir Driver Registration
    Route::group([
        'prefix' => 'driver',
    ], function () {
        Route::get('/', [DriverRegistrationController::class, 'RegistrationPage'])->name('driver.index')->middleware('can:Create Driver');
        Route::post('/store', [DriverRegistrationController::class, 'store'])->name('driver.store')->middleware('can:Create Driver');
        Route::delete('/delete/{driver}', [DriverRegistrationController::class, 'destroy'])->name('driver.destroy')->middleware('can:Create Driver');
        Route::put('/update/{driver}', [DriverRegistrationController::class, 'update'])->name('driver.update')->middleware('can:Create Driver');
        Route::post('/update-status', [DriverRegistrationController::class, 'updateStatus'])->name('driver.status')->middleware('can:Create Driver');
    });

    Route::group([
        'prefix' => 'driver_change',
    ], function () {
        Route::get('/', [DriverChangeController::class, 'driver_change_page'])->name('driver.switch')->middleware('can:Change Driver');
        Route::get('/request', [DriverChangeController::class, 'driver_get_request'])->name('driverchange.request');
        Route::get('/my_request', [DriverChangeController::class, 'driver_get_request'])->name('driver.requestPage');
        Route::post('/store', [DriverChangeController::class, 'store'])->name('driver_change.store')->middleware('can:Change Driver');
        Route::post('/accept', [DriverChangeController::class, 'driver_accept'])->name('driver_change.accept')->middleware('can:Accept Driver Change');
        Route::put('/update/{request_id}', [DriverChangeController::class, 'update'])->name('driverchange.update')->middleware('can:Change Driver');
        Route::delete('/delete/{request_id}', [DriverChangeController::class, 'destroy'])->name('driverchange.destroy')->middleware('can:Change Driver');
    });
    Route::group([
        'prefix' => 'Route',
    ], function () {
        Route::get('/', [RouteController::class, 'displayAllRoutes'])->name('route.index');
        Route::get('/self_route', [RouteController::class, 'own_route'])->name('route.self_route_self');
        Route::get('/user', [RouteController::class, 'displayRoute'])->name('route.show');
        Route::post('/store', [RouteController::class, 'registerRoute'])->name('route.store');
        Route::post('/employee/store', [RouteController::class, 'assignUsersToRoute'])->name('employeeService.store');
        Route::put('/change/{request_id}', [RouteController::class, 'updateRoute'])->name('route.change');
        Route::put('/update/{route_id}', [RouteController::class, 'update'])->name('route.updates');
        Route::delete('/delete/{request_id}', [RouteController::class, 'removeRoute'])->name('route.destroy');
        Route::delete('/user/delete/{request_id}', [RouteController::class, 'removeUserFromRoute'])->name('routeUser.destroy');
        Route::post('/update-location', [RouteController::class, 'updateLocation'])->name('employee.updateLocation');;
    });

    // Define routes for InspectionController
    Route::controller(InspectionController::class)->group(function () {
        Route::post('/inspection/store', 'storeInspection')->name('inspection.store')->middleware('can:Vehicle Inspection');  // Create a new inspection
        Route::post('/inspection/show', 'showInspection')->name('inspection.show.specific'); // Show a specific inspection
        // Route::get('/inspect_vehicle/{id}', 'showInspectionbyVehicle')->name('inspection.ByVehicle'); 
        Route::get('/inspection', 'showInspectionbyVehicle')->name('inspection.ByVehicle'); // Show a specific inspection
        Route::get('/inspections', 'listInspections')->name('inspection.list')->middleware('can:Vehicle Inspection'); // List all inspections
        Route::get('/inspections/page', 'InspectionPage')->name('inspection.page')->middleware('can:Vehicle Inspection'); // inspection page
        // Route::get('/inspect_vehicle/{id}', 'showInspectionbyVehicle');//->name('inspection.ByVehicle'); // inspection page
        Route::put('/inspection/{inspectionId}/{partName}', 'updateInspection')->name('inspection.update')->middleware('can:Vehicle Inspection'); // Update a specific inspection
        Route::delete('/inspection/{inspectionId}', 'deleteInspection')->name('inspection.delete')->middleware('can:Vehicle Inspection'); // Delete a specific inspection
    });
    Route::controller(NotificationController::class)->group(function () {
        Route::post('/delete_notification', 'delete_notification')->name('delete_all_notification');
        Route::get('/read_all_notifications', 'read_all_notifications')->name('read_all_notification');
        Route::get('/get_all_notifications', 'get_all_notifications')->name('get_all_notifications');
        Route::get('/clear_all_notifications', 'clear_all_notifications');
        Route::get('/get_new_message_count', 'get_new_message_count');
        Route::post('/change_status', 'redirect_to_inteded');
    });
    Route::controller(EmployeeChangeLocationController::class)->group(function () {
        Route::get('/approve_page', 'simiritPage')->name('change.location_change_approve');
        Route::post('/change_location', 'store')->name('location_change_request');
        Route::post('/approve_change_location', 'approve_change')->name('approve_employee_location');
    });
    // Vehicle attendance controller
    Route::controller(AttendanceController::class)->group(function () {
        Route::get('/attendance', 'index')->name('attendance.index')->middleware('can:Fill Attendance');
        Route::get('/attendance/fetch', 'FetchAttendance')->name('FetchAttendance')->middleware('can:Fill Attendance');
        Route::post('/attendance/store', 'store')->name('attendance.store')->middleware('can:Fill Attendance');
        Route::post('/attendance/update/{id}', 'update')->name('attendance.update')->middleware('can:Fill Attendance');
        Route::delete('/attendance/delete', 'destroy')->name('attendance.destroy')->middleware('can:Fill Attendance');
        Route::get('/attendance/report', 'ReportPage')->name('attendancereport.index')->middleware('can:View Attendance Report');
        Route::get('/attendance/report/filter', 'filterReport')->name('attendancereport.filter')->middleware('can:View Attendance Report');
    });
    // letter 
    Route::controller(LetterManagement::class)->group(function () {
        Route::get('/letter', 'index')->name('letter.index')->middleware('can:Attach Letter');
        Route::get('/letter/fetch', 'FetchLetter')->name('FetchLetter');
        Route::post('/letter/store', 'store')->name('letter.store')->middleware('can:Attach Letter');
        Route::get('/letter/review', 'review_page')->name('letter.review.page')->middleware('can:Letter Review');
        Route::get('/letter/fetch/department', 'FetchLetterApprove')->name('FetchForLetterRequest');
        Route::post('/letter/review/{id}', 'review')->name('letter.review')->middleware('can:Letter Review');
        Route::get('/letter/approve', 'approve_page')->name('letter.approve.page')->middleware('can:Letter Approve');
        Route::post('/letter/approve/{id}', 'approve')->name('letter.approve')->middleware('can:Letter Approve');
        Route::get('/letter/accept/purchase', 'accept_page_purchase')->name('purchase.accept.page')->middleware('can:Purchase Letter');
        Route::get('/letter/accept/finance', 'accept_page_finance')->name('finance.accept.page')->middleware('can:Finance Letter');
        Route::post('/letter/accept/{id}', 'accept')->name('letter.accept');
        Route::delete('/letter/delete', 'destroy')->name('attendance.destroy')->middleware('can:Attach Letter');
    });
    // Replacement

    Route::controller(ReplacementController::class)->group(function () {
        Route::get('/Replacement', 'index')->name('Replacement.index');
        Route::get('/Replacement/fetch', 'FetchReplacement')->name('Replacement.fetch');
        Route::post('/Replacement/store', 'store')->name('Replacement.store');
        Route::post('/Replacement/update/{id}', 'update')->name('Replacement.update');
        Route::delete('/Replacement/delete/{id}', 'destroy')->name('Replacement.delete');
    });
    // SAMIR
    // Route::group([
    //         'prefix'=>'vehicle',
    //     ], function (){
    //         Route::get('/',[VehicleRegistrationController::class, 'index'])->name('vehicleRegistration.index');
    //         Route::post('/store',[VehicleRegistrationController::class, 'store'])->name('vehicleRegistration.store');
    //         Route::delete('/delete/{vehicle}',[VehicleRegistrationController::class,'destroy'])->name('vehicle.destroy');
    //         Route::put('/update/{vehicle}', [VehicleRegistrationController::class, 'update'])->name('vehicle.update');
    //     });
    // Route::controller(VehicleRegistrationController::class)->group(function () 
    //     {
    //          Route::get('/xx', 'index')->name('vehicleRegistration.index'); 
    //          Route::post('/store', 'store')->name('vehicle.store'); 
    //          Route::delete('/delete/{vehicle}', 'destroy')->name('vehicle.destroy'); 
    //          Route::put('/update/{vehicle}', 'update')->name('vehicle.update'); 
    //     });
    // Define routes for VehiclePartsController
    Route::controller(VehiclePartsController::class)->group(function () {
        Route::post('/vehicle-parts', 'store')->name('vehicle_parts.store')->middleware('can:Vehicle Part Registration'); // Create a new vehicle part
        Route::get('/vehicle-parts-show/{id}', 'show')->name('vehicle_parts.show'); // Retrieve a specific vehicle part
        Route::get('/vehicle-parts', 'index')->name('vehicle_parts.index')->middleware('can:Vehicle Part Registration'); // List all vehicle parts
        Route::post('/vehicle-parts-update/{id}', 'update')->name('vehicle_parts.update')->middleware('can:Vehicle Part Registration'); // Update a vehicle part
        Route::delete('/vehicle-parts-delete/{id}', 'destroy')->name('vehicle_parts.destroy')->middleware('can:Vehicle Part Registration'); // Delete a vehicle part
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('locale/{lang}', [LocaleController::class, 'setlocale'])->name('locale.switch');

    Route::group([
        'prefix' => 'cluster',
    ], function () {
        Route::get('/', [ClusterController::class, 'index'])->name('cluster.index')->middleware('can:Create Cluster');
        Route::get('/create', [ClusterController::class, 'create'])->name('cluster.create')->middleware('can:Create Cluster');
        Route::post('/store', [ClusterController::class, 'store'])->name('cluster.store')->middleware('can:Create Cluster');
        Route::post('/{cluster}/update', [ClusterController::class, 'update'])->name('cluster.update')->middleware('can:Create Cluster');
        Route::get('/view', [ClusterController::class, 'show'])->name('cluster.show')->middleware('can:Create Cluster');
        Route::delete('/delete/{cluster}', [ClusterController::class, 'destroy'])->name('cluster.destroy')->middleware('can:Create Cluster');
    });
    Route::group([
        'prefix' => 'department',
    ], function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('department.index')->middleware('can:Create Department');
        // Route::get('/create',[DepartmentController::class,'create'])->name('department.create');
        Route::post('/store', [DepartmentController::class, 'store'])->name('department.store')->middleware('can:Create Department');
        Route::post('/{department}/update', [DepartmentController::class, 'update'])->name('department.update')->middleware('can:Create Department');
        Route::delete('/delete/{department}', [DepartmentController::class, 'destroy'])->name('department.destroy')->middleware('can:Create Department');
    });

    //filters


});
