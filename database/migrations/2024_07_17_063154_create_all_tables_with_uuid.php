<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTablesWithUuid extends Migration
{
    public function up()
    {
        // Users Table
        // Assuming the 'users' table is already created
        // Clusters Table
        Schema::create('clusters', function (Blueprint $table) {
            $table->uuid('cluster_id')->primary();
            $table->string('name', 255);
            $table->uuid('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });

        // Departments Table
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid('department_id')->primary();
            $table->string('name', 255);
            $table->uuid('cluster_id');
            $table->foreign('cluster_id')->references('cluster_id')->on('clusters')->onDelete('restrict');
            $table->uuid('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });

        // Drivers Table
        Schema::create('drivers', function (Blueprint $table) {
            $table->uuid('driver_id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->string('license_number', 255);
            $table->date('license_expiry_date');
            $table->string('status', 255)->default('active');
            $table->string('license_file', 255);
            //$table->string('phone_number', 20);
            $table->uuid('register_by');
            $table->foreign('register_by')->references('id')->on('users')->onDelete('restrict');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        // Vehicles Table
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('vehicle_id')->primary();
            $table->uuid('inspection_id')->nullable();
            $table->string('vin', 255);
            $table->string('make', 255);
            $table->string('model', 255);
            $table->integer('year');
            $table->string('plate_number', 255);
            $table->date('registration_date');
            $table->integer('mileage');
            $table->string('vehicle_type', 255);
            $table->string('libre', 255)->nullable();
            $table->string('insurance', 255)->nullable();
            $table->string('vehicle_category', 255);
            $table->decimal('fuel_amount', 10, 2);
            $table->integer('last_service')->nullable();
            $table->integer('next_service')->nullable();
            $table->uuid('registered_by')->nullable();
            $table->foreign('registered_by')->references('id')->on('users')->onDelete('restrict');
            $table->uuid('driver_id')->nullable();
            $table->foreign('driver_id')->references('driver_id')->on('drivers')->onDelete('restrict');
            $table->string('fuel_type', 255);
            $table->boolean('status')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Locations Table
        Schema::create('locations', function (Blueprint $table) {
            $table->uuid('location_id')->primary();
            $table->string('name', 255);
            $table->string('address', 255);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Vehicle Parts Table
            Schema::create('vehicle_parts', function (Blueprint $table) {
                $table->uuid('vehicle_parts_id')->primary();
                $table->string('type')->options('[spare_part,vehicle_part]');
                $table->uuid('name');
                $table->string('notes');
                $table->uuid('created_by');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');
                $table->timestamps();
                $table->softDeletes();
            });
        // Vehicle Detail
        Schema::create('vehicles_detail', function (Blueprint $table) {
            $table->uuid('detail_id')->primary();
            $table->string('detail', 2000)->default('Unread');
            $table->uuid('register_by');
            $table->foreign('register_by')->references('id')->on('users')->onDelete('restrict');
            $table->date('date');
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->integer('mileage');
            $table->uuid('driver_id');
            $table->foreign('driver_id')->references('driver_id')->on('drivers')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });

        // Vehicle Inspection
        Schema::create('vehicle_inspections', function (Blueprint $table) {
            $table->uuid('inspection_id');  // Inspection session ID
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->uuid('inspected_by');
            $table->foreign('inspected_by')->references('id')->on('users');
            $table->uuid('part_name');
            $table->foreign('part_name')->references('vehicle_parts_id')->on('vehicle_parts')->onDelete('restrict');
            $table->boolean('is_damaged')->default(false);
            $table->text('damage_description')->nullable();
            $table->dateTime('inspection_date');  // Time of inspection
            $table->string('inspection_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['inspection_id', 'part_name', 'inspected_by']);  // Composite primary key to avoid duplication
        });
        // driver change
        Schema::create('driver_changes', function (Blueprint $table) {
            $table->uuid('driver_change_id')->primary();
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->uuid('new_driver_id');
            $table->foreign('new_driver_id')->references('driver_id')->on('drivers')->onDelete('restrict');
            $table->uuid('old_driver_id');
            $table->foreign('old_driver_id')->references('driver_id')->on('drivers')->onDelete('restrict');
            $table->uuid('changed_by');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('restrict');
            $table->uuid('inspection_id');  // Link to the entire inspection session
            $table->foreign('inspection_id')->references('inspection_id')->on('vehicle_inspections')->onDelete('restrict');
            $table->boolean('driver_accepted')->default(0);
            $table->string('driver_reject_reason', 1000)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
         // Change Fuel Quata
         Schema::create('fuel_quatas', function (Blueprint $table) {
            $table->uuid('fuel_quata_id')->primary();
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->integer('old_quata');
            $table->integer('new_quata');
            $table->uuid('changed_by');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
        // Vehicle Request Permanently
        Schema::create('vehicle_requests_parmanently', function (Blueprint $table) {
            $table->uuid('vehicle_request_permanent_id')->primary();
            $table->uuid('requested_by');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('position_letter');
            $table->integer('fuel_quata')->nullable();
            $table->integer('feul_left_from_prev')->nullable();
            $table->string('purpose');
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('director_reject_reason', 1000)->nullable();
            $table->uuid('given_by')->nullable();
            $table->foreign('given_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('vec_director_reject_reason', 1000)->nullable();
            $table->uuid('accepted_by_requestor')->nullable();
            $table->foreign('accepted_by_requestor')->references('id')->on('users')->onDelete('restrict');
            $table->string('reject_reason_by_requestor', 1000)->nullable();
            $table->date('given_date')->nullable();
            $table->uuid('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->integer('mileage')->nullable();
            $table->uuid('inspection_id')->nullable();  // Link to the entire inspection session
            $table->foreign('inspection_id')->references('inspection_id')->on('vehicle_inspections')->onDelete('restrict');
            $table->boolean('status')->default(true); // COLUMN THAT SHOWS VEHICLE RETURNED OR NOT
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('giving_back_vehicles_parmanently', function (Blueprint $table) {
            $table->uuid('giving_back_vehicle_id')->primary();
            $table->uuid('requested_by');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('purpose');
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('reject_reason_vec_director')->nullable();
            $table->uuid('received_by')->nullable();
            $table->foreign('received_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('reject_reason_dispatcher')->nullable();
            $table->date('returned_date')->nullable();
            $table->uuid('permanent_request')->nullable();
            $table->foreign('permanent_request')->references('vehicle_request_permanent_id')->on('vehicle_requests_parmanently')->onDelete('restrict');
            // $table->uuid('inspection_id')->nullable();  // Link to the entire inspection session
            // $table->foreign('inspection_id')->references('inspection_id')->on('vehicle_inspections');
            $table->boolean('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        // Maintenance Table
        Schema::create('maintenances', function (Blueprint $table) {
            $table->uuid('maintenance_id')->primary();
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->uuid('requested_by');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('restrict');
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('director_reject_reason', 1000)->nullable();
            $table->uuid('sim_approved_by')->nullable();
            $table->foreign('sim_approved_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('simirit_reject_reason', 1000)->nullable();
            $table->string('maintenance_type', 255);
            $table->uuid('maintained_by')->nullable();
            $table->foreign('maintained_by')->references('id')->on('users')->onDelete('restrict');
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->uuid('vehicle_detail_id')->nullable();
            $table->foreign('vehicle_detail_id')->references('detail_id')->on('vehicles_detail')->onDelete('restrict');
            $table->uuid('taking_inspection')->nullable();  // Link to the entire inspection session
            $table->foreign('taking_inspection')->references('inspection_id')->on('vehicle_inspections')->onDelete('restrict');
            $table->uuid('giving_inspection')->nullable();  // Link to the entire inspection session
            $table->foreign('giving_inspection')->references('inspection_id')->on('vehicle_inspections')->onDelete('restrict');
            $table->decimal('cost', 10, 2)->nullable();
            $table->text('parts_used')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Fueling Table
        Schema::create('fuelings', function (Blueprint $table) {
            $table->uuid('fueling_id')->primary();
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->uuid('driver_id');
            $table->foreign('driver_id')->references('driver_id')->on('drivers')->onDelete('restrict');
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('direct_reject_reason')->nullable();
            $table->date('fuiling_date')->nullable();
            $table->uuid('vec_director_id')->nullable();
            $table->foreign('vec_director_id')->references('id')->on('users')->onDelete('restrict');
            $table->string('vec_direct_reject_reason')->nullable();
            $table->uuid('service_given_by')->nullable();
            $table->foreign('service_given_by')->references('id')->on('users')->onDelete('restrict');
            $table->integer('mileage')->nullable();
            $table->decimal('fuel_amount', 10, 2);
            $table->decimal('fuel_cost', 10, 2)->nullable();
            $table->uuid('location_id')->nullable();
            $table->foreign('location_id')->references('location_id')->on('locations')->onDelete('restrict');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
      // Fueling Table
      Schema::create('Permanent_fuelings', function (Blueprint $table) {
        $table->uuid('fueling_id');  // Primary key is just fueling_id, without month
        $table->uuid('vehicle_id');
        $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
        
        $table->uuid('driver_id');
        $table->foreign('driver_id')->references('driver_id')->on('drivers')->onDelete('restrict');
        
        $table->uuid('finance_approved_by')->nullable();
        $table->foreign('finance_approved_by')->references('id')->on('users')->onDelete('restrict');
        
        $table->uuid('permanent_id')->nullable();
        $table->foreign('permanent_id')->references('vehicle_request_permanent_id')->on('vehicle_requests_parmanently')->onDelete('restrict');
        
        $table->string('reject_reason')->nullable();
        $table->date('fuiling_date');
        $table->integer('year');
        $table->string('month');
        $table->integer('fuel_amount');
        $table->decimal('fuel_cost', 8, 2);
        $table->string('reciet_attachment');

        $table->timestamps();
        $table->softDeletes();
    
        // Add a unique constraint on the combination of fueling_id and month
        $table->primary(['year', 'month', 'driver_id']);  // Composite primary key to avoid duplication

    });
        // GPS Tracking Table
        Schema::create('gps_tracking', function (Blueprint $table) {
            $table->uuid('tracking_id')->primary();
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->dateTime('tracking_date');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->timestamps();
            $table->softDeletes();
        });

        // Trips Table
        Schema::create('trips', function (Blueprint $table) {
            $table->uuid('trip_id')->primary();
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->uuid('driver_id');
            $table->foreign('driver_id')->references('driver_id')->on('drivers')->onDelete('restrict');
            $table->date('date');
            $table->string('route', 1000)->nullable();
            $table->text('purpose');
            $table->uuid('register_by');
            $table->foreign('register_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('notes', 1000)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        // Route
        Schema::create('routes', function (Blueprint $table) {
            $table->uuid('route_id')->primary();
            $table->string('route_name');
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->integer('driver_phone');
            $table->uuid('registered_by');
            $table->foreign('registered_by')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('route_user', function (Blueprint $table) {
            $table->uuid('route_user_id')->primary();
            $table->uuid('employee_id');
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('restrict');
            $table->uuid('route_id');
            $table->foreign('route_id')->references('route_id')->on('routes')->onDelete('restrict');
            $table->uuid('registered_by');
            $table->foreign('registered_by')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
        // Driver Logs Table
        Schema::create('daily_km_calculations', function (Blueprint $table) {
            $table->uuid('calculation_id')->primary();
            $table->integer('morning_km')->nullable();
            $table->integer('afternoon_km')->nullable();
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->uuid('driver_id');
            $table->foreign('driver_id')->references('driver_id')->on('drivers')->onDelete('restrict');
            $table->uuid('register_by');
            $table->foreign('register_by')->references('id')->on('users')->onDelete('restrict');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
        });
        // Vehicle Requests Temporary Table
        Schema::create('vehicle_requests_temporary', function (Blueprint $table) {
            $table->uuid('request_id')->primary();
            $table->uuid('requested_by_id');
            $table->foreign('requested_by_id')->references('id')->on('users')->onDelete('restrict');
            $table->string('vehicle_type', 255);
            $table->string('purpose', 255);
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date');
            $table->time('end_time');
            $table->boolean('in_out_town');
            $table->integer('how_many_days');
            $table->integer('start_km')->nullable();
            $table->integer('end_km')->nullable();
            $table->string('status', 255)->default('Pending');
            $table->boolean('with_driver')->default(1);
            $table->uuid('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->uuid('dir_approved_by')->nullable();
            $table->foreign('dir_approved_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('director_reject_reason', 1000)->nullable();
            $table->uuid('div_approved_by')->nullable();
            $table->foreign('div_approved_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('cluster_director_reject_reason', 1000)->nullable();
            $table->uuid('hr_div_approved_by')->nullable();
            $table->foreign('hr_div_approved_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('hr_director_reject_reason', 1000)->nullable();
            $table->uuid('taken_by')->nullable();
            $table->foreign('taken_by')->references('id')->on('users')->onDelete('restrict');
            $table->uuid('assigned_by')->nullable();
            $table->foreign('assigned_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('assigned_by_reject_reason', 1000)->nullable();
            $table->uuid('transport_director_id')->nullable();
            $table->foreign('transport_director_id')->references('id')->on('users')->onDelete('restrict');
            $table->string('vec_director_reject_reason', 1000)->nullable();
            $table->string('start_location', 255);
            $table->string('end_locations', 255);
            $table->decimal('allowed_distance_after_destination', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->string('comment', 255)->nullable();
            $table->decimal('km_per_liter', 10, 2)->nullable();
            $table->uuid('driver_id')->nullable();
            $table->foreign('driver_id')->references('driver_id')->on('drivers')->onDelete('restrict');
            $table->uuid('taking_inspection')->nullable();  // Link to the entire inspection session
            $table->foreign('taking_inspection')->references('inspection_id')->on('vehicle_inspections')->onDelete('restrict');
            $table->uuid('returning_inspection')->nullable();  // Link to the entire inspection session
            $table->foreign('returning_inspection')->references('inspection_id')->on('vehicle_inspections')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
        // Trip material table
        Schema::create('trip_materials', function (Blueprint $table) {
            $table->uuid('trip_material_id')->primary();
            $table->string('material_name', 1000);
            $table->float('weight');
            $table->uuid('request_id');
            $table->foreign('request_id')->references('request_id')->on('vehicle_requests_temporary')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
        // Trip Person Table
        Schema::create('trip_person', function (Blueprint $table) {
            $table->uuid('trip_person_id')->primary();
            $table->uuid('request_id');
            $table->foreign('request_id')->references('request_id')->on('vehicle_requests_temporary')->onDelete('restrict');
            $table->uuid('employee_id');

            $table->foreign('employee_id')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trip_person');
        Schema::dropIfExists('trip_materials');
        Schema::dropIfExists('vehicle_requests_temporary');
        Schema::dropIfExists('daily_km_calculation');
        Schema::dropIfExists('trips');
        Schema::dropIfExists('gps_tracking');
        Schema::dropIfExists('fuelings');
        Schema::dropIfExists('maintenances');
        Schema::dropIfExists('giving_back_vehicles_parmanently');
        Schema::dropIfExists('vehicle_requests_parmanently');
        Schema::dropIfExists('driver_changes');
        Schema::dropIfExists('vehicle_inspections');
        Schema::dropIfExists('vehicles_detail');
        Schema::dropIfExists('vehicle_parts');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('clusters');
    }
}
