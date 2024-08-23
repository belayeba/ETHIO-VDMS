
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Uuid;

class CreateAllTablesWithUuid extends Migration
{
    public function up()
    {    
         // Departments Table
         Schema::create('clusters', function (Blueprint $table) {
            $table->uuid('cluster_id')->primary();
            $table->string('name', 255);
            $table->uuid('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid('department_id')->primary();
            $table->string('name', 255);
            $table->uuid('cluster_id');
            $table->uuid('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
           // Drivers Table
           Schema::create('drivers', function (Blueprint $table) {
            $table->uuid('driver_id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('license_number', 255);
            $table->date('license_expiry_date');
            $table->string('status', 255)->default('active');
            $table->string('phone_number', 20);
            $table->uuid('register_by');
            $table->foreign('register_by')->references('id')->on('users');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
            // Vehicles Table
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('vehicle_id')->primary();
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
            $table->foreign('registered_by')->references('id')->on('users');
            $table->uuid('driver_id')->nullable();
            $table->foreign('driver_id')->references('driver_id')->on('drivers');
            $table->string('fuel_type', 255);
            $table->string('status', 255);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

          // Vehicle Detail
          Schema::create('vehicles_detail', function (Blueprint $table) {
            $table->uuid('detail_id')->primary();
            $table->string('detail', 2000)->default('Unread');
            $table->uuid('register_by');
            $table->foreign('register_by')->references('id')->on('users');
            $table->date('date');
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
            $table->integer('mileage');
            $table->uuid('driver_id');
            $table->foreign('driver_id')->references('driver_id')->on('drivers');
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

        // Maintenance Table
        Schema::create('maintenances', function (Blueprint $table) {
            $table->uuid('maintenance_id')->primary();
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
            $table->uuid('requested_by');
            $table->foreign('requested_by')->references('id')->on('users');
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->string('director_reject_reason',1000)->nullable();
            $table->uuid('sim_approved_by')->nullable();
            $table->foreign('sim_approved_by')->references('id')->on('users');
            $table->string('simirit_reject_reason',1000)->nullable();
            $table->string('maintenance_type', 255);
            $table->uuid('maintained_by')->nullable();
            $table->foreign('maintained_by')->references('id')->on('users');
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->uuid('vehicle_detail_id')->nullable();
            $table->foreign('vehicle_detail_id')->references('detail_id')->on('vehicles_detail');
            $table->uuid('taking_inspection')->nullable();  // Link to the entire inspection session
            $table->foreign('taking_inspection')->references('inspection_id')->on('vehicle_inspections');
            $table->uuid('giving_inspection')->nullable();  // Link to the entire inspection session
            $table->foreign('giving_inspection')->references('inspection_id')->on('vehicle_inspections');
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
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
            $table->uuid('driver_id');
            $table->foreign('driver_id')->references('driver_id')->on('drivers');
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->string('direct_reject_reason')->nullable();
            $table->date('fuiling_date')->nullable();
            $table->uuid('vec_director_id')->nullable();
            $table->foreign('vec_director_id')->references('id')->on('users');
            $table->string('vec_direct_reject_reason')->nullable();
            $table->uuid('service_given_by')->nullable();
            $table->foreign('service_given_by')->references('id')->on('users');
            $table->integer('mileage')->nullable();
            $table->decimal('fuel_amount', 10, 2);
            $table->decimal('fuel_cost', 10, 2)->nullable();
            $table->uuid('location_id')->nullable();
            $table->foreign('location_id')->references('location_id')->on('locations');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
           // GPS Tracking Table
        Schema::create('gps_tracking', function (Blueprint $table) {
                $table->uuid('tracking_id')->primary();
                $table->uuid('vehicle_id');
                $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
                $table->timestamp('timestamp');
                $table->decimal('latitude', 10, 8);
                $table->decimal('longitude', 11, 8);
                $table->decimal('speed', 10, 2)->nullable();
                $table->decimal('altitude', 10, 2)->nullable();
                $table->timestamps();
                $table->softDeletes();
        });
          // Driver Logs Table
        Schema::create('driver_logs', function (Blueprint $table) {
                $table->uuid('log_id')->primary();
                $table->uuid('driver_id');
                $table->foreign('driver_id')->references('driver_id')->on('drivers');
                $table->date('date');
                $table->time('start_time');
                $table->time('end_time');
                $table->integer('mileage');
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();
        });
             // Vehicle Inspection
             Schema::create('vehicle_inspections', function (Blueprint $table) {
                $table->uuid('inspection_id');  // Inspection session ID
                $table->uuid('vehicle_id');
                $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
                $table->uuid('inspected_by');
                $table->foreign('inspected_by')->references('id')->on('users');
                $table->string('part_name');  // Each part of the vehicle
                $table->boolean('is_damaged')->default(false);
                $table->text('damage_description')->nullable();
                $table->dateTime('inspection_date');  // Time of inspection
                $table->timestamps();
                $table->softDeletes();
                $table->primary(['inspection_id', 'part_name']);  // Composite primary key to avoid duplication
        });
          // trip person
          Schema::create('vehicle_parts', function (Blueprint $table) 
                {
                        $table->uuid('vehicle_parts_id')->primary();
                        $table->uuid('name');
                        $table->string('notes');
                        $table->timestamps();
                        $table->softDeletes();
                });
            // Vehicle Inspection
        Schema::create('vehicle_inspections', function (Blueprint $table) {
                $table->uuid('inspection_id');  // Inspection session ID
                $table->uuid('vehicle_id');
                $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
                $table->uuid('inspected_by');
                $table->foreign('inspected_by')->references('id')->on('users');
                $table->uuid('part_name');
                $table->foreign('part_name')->references('vehicle_parts_id')->on('vehicle_parts');
                $table->boolean('is_damaged')->default(false);
                $table->text('damage_description')->nullable();
                $table->dateTime('inspection_date');  // Time of inspection
                $table->timestamps();
                $table->softDeletes();
                $table->primary(['inspection_id', 'part_name']);  // Composite primary key to avoid duplication
        });
          // Vehicle Requests Temporary Table
        Schema::create('vehicle_requests_temporary', function (Blueprint $table) {
                $table->uuid('request_id')->primary();
                $table->uuid('requested_by_id');
                $table->foreign('requested_by_id')->references('id')->on('users');
                $table->string('vehicle_type', 255);
                $table->string('purpose', 255);
                $table->date('start_date');
                $table->time('start_time');
                $table->date('end_date');
                $table->time('end_time');
                $table->boolean('in_out_town');
                $table->integer('start_km')->nullable();
                $table->integer('end_km')->nullable();
                $table->string('status', 255)->default('Pending');
                $table->boolean('with_driver')->default(1);
                $table->uuid('vehicle_id')->nullable();
                $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
                $table->uuid('dir_approved_by')->nullable();
                $table->foreign('dir_approved_by')->references('id')->on('users');
                $table->uuid('div_approved_by')->nullable();
                $table->foreign('div_approved_by')->references('id')->on('users');
                $table->uuid('hr_div_approved_by')->nullable();
                $table->foreign('hr_div_approved_by')->references('id')->on('users');
                $table->string('director_reject_reason', 1000)->nullable();
                $table->uuid('assigned_by')->nullable();
                $table->foreign('assigned_by')->references('id')->on('users');
                $table->string('vec_director_reject_reason', 1000)->nullable();
                $table->string('start_location', 255);
                $table->string('end_locations', 255);
                $table->decimal('allowed_distance_after_destination', 10, 2)->nullable();
                $table->text('notes')->nullable();
                $table->string('comment', 255)->nullable();
                $table->decimal('km_per_liter', 10, 2)->nullable();
                $table->uuid('driver_accepted_by')->nullable();
                $table->foreign('driver_accepted_by')->references('id')->on('users');
                $table->uuid('taking_inspection')->nullable();  // Link to the entire inspection session
                $table->foreign('taking_inspection')->references('inspection_id')->on('vehicle_inspections');
                $table->uuid('returning_inspection')->nullable();  // Link to the entire inspection session
                $table->foreign('returning_inspection')->references('inspection_id')->on('vehicle_inspections');
                $table->timestamps();
                $table->softDeletes();
        });
        // Notifications Table
        Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('notification_id')->primary();
                $table->uuid('user_id');
                $table->foreign('user_id')->references('id')->on('users');
                $table->text('message');
                $table->string('is_read', 8)->default('Unread');
                $table->timestamps();
                $table->softDeletes();
        });

        // Driver Communications Table
        Schema::create('driver_communications', function (Blueprint $table) {
                $table->uuid('communication_id')->primary();
                $table->uuid('driver_id');
                $table->foreign('driver_id')->references('driver_id')->on('drivers');
                $table->uuid('sender_id');
                $table->foreign('sender_id')->references('id')->on('users');
                $table->text('message');
                $table->string('status', 255)->default('Sent');
                $table->timestamps();
                $table->softDeletes();
        });

        // Service Employee Table
        Schema::create('service_employee', function (Blueprint $table) 
            {
                $table->uuid('service_employee_id')->primary();
                $table->string('name', 255);
                $table->string('email', 255)->unique();
                $table->string('phone_number', 255)->unique();
                $table->timestamps();
                $table->softDeletes();
            });
// Driver Logs Table
        Schema::create('daily_km_calculations', function (Blueprint $table) {
                $table->uuid('calculation_id')->primary();
                $table->decimal('morning_km', 10, 8)->nullable();
                $table->decimal('afternoon_km', 10, 8)->nullable();
                $table->uuid('vehicle_id');
                $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
                $table->uuid('driver_id');
                $table->foreign('driver_id')->references('driver_id')->on('drivers');
                $table->uuid('register_by');
                $table->foreign('register_by')->references('id')->on('users');
                $table->date('date');
                $table->timestamps();
                $table->softDeletes();
        });
         // Driver Logs Table
         Schema::create('vehicle_requests_parmanently', function (Blueprint $table) {
                $table->uuid('vehicle_request_permanent_id')->primary();
                $table->uuid('requested_by');
                $table->foreign('requested_by')->references('id')->on('users');
                $table->string('position_letter');
                $table->string('purpose');
                $table->uuid('approved_by')->nullable();
                $table->foreign('approved_by')->references('id')->on('users');
                $table->string('director_reject_reason', 1000)->nullable();
                $table->uuid('given_by')->nullable();
                $table->foreign('given_by')->references('id')->on('users');
                $table->string('vec_director_reject_reason', 1000)->nullable();
                $table->date('given_date')->nullable();
                $table->uuid('vehicle_id')->nullable();
                $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
                $table->integer('mileage')->nullable();
                $table->uuid('inspection_id')->nullable();  // Link to the entire inspection session
                $table->foreign('inspection_id')->references('inspection_id')->on('vehicle_inspections');
                $table->integer('status')->nullable();
                $table->timestamps();
                $table->softDeletes();
        });
         
         // Giving back Permanent Vehicle Request 
         Schema::create('giving_back_vehicles_parmanently', function (Blueprint $table) {
                $table->uuid('giving_back_vehicle_id')->primary();
                $table->uuid('requested_by');
                $table->foreign('requested_by')->references('id')->on('users');
                $table->uuid('vehicle_id');
                $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
                $table->uuid('approved_by')->nullable();
                $table->string('purpose');
                $table->string('reject_reason_vec_dire')->nullable();
                $table->string('reject_reason_director')->nullable();
                $table->foreign('approved_by')->references('id')->on('users');
                $table->uuid('received_by')->nullable();
                $table->foreign('received_by')->references('id')->on('users');
                $table->date('returned_date')->nullable();
                $table->uuid('vehicle_request_id')->nullable();
                $table->foreign('vehicle_request_id')->references('vehicle_request_permanent_id')->on('vehicle_requests_parmanently');
                $table->uuid('vehicle_detail_id')->nullable();
                $table->foreign('vehicle_detail_id')->references('detail_id')->on('vehicles_detail');
                $table->uuid('inspection_id')->nullable();  // Link to the entire inspection session
                $table->foreign('inspection_id')->references('inspection_id')->on('vehicle_inspections');
                $table->integer('status')->nullable();
                $table->timestamps();
                $table->softDeletes();
        }); 
       
        // trip person
          Schema::create('trip_person', function (Blueprint $table) 
          {
                $table->uuid('trip_person_id')->primary();
                $table->uuid('request_id');
                $table->foreign('request_id')->references('request_id')->on('vehicle_requests_temporary');
                $table->uuid('employee_id');

                $table->foreign('employee_id')->references('id')->on('users');
                $table->timestamps();
                $table->softDeletes();
        });
         
          // Vehicle Detail
          Schema::create('trip_materials', function (Blueprint $table) 
            {
                    $table->uuid('trip_material_id')->primary();
                    $table->string('material_name', 1000);
                    $table->float('weight');
                    $table->uuid('request_id');
                    $table->foreign('request_id')->references('request_id')->on('vehicle_requests_temporary');
                    $table->timestamps();
                    $table->softDeletes();
            });
        // driver change
        Schema::create('driver_changes', function (Blueprint $table) 
            {
                $table->uuid('driver_change_id')->primary();
                $table->uuid('vehicle_id');
                $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
                $table->uuid('new_driver_id');
                $table->foreign('new_driver_id')->references('id')->on('users');
                $table->uuid('old_driver_id');
                $table->foreign('old_driver_id')->references('id')->on('users');
                $table->uuid('inspection_id');  // Link to the entire inspection session
                $table->foreign('inspection_id')->references('inspection_id')->on('vehicle_inspections');
                $table->timestamps();
                $table->softDeletes();
            });        
    }
    public function down()
        {
            Schema::dropIfExists('vehicles');
            Schema::dropIfExists('drivers');
            Schema::dropIfExists('vehicle_parts');
            Schema::dropIfExists('locations');
            Schema::dropIfExists('maintenances');
            Schema::dropIfExists('fuelings');
            Schema::dropIfExists('gps_tracking');
            Schema::dropIfExists('driver_logs');
            Schema::dropIfExists('vehicle_requests_temporary');
            Schema::dropIfExists('notifications');
            Schema::dropIfExists('driver_communications');
            Schema::dropIfExists('service_employee');
            Schema::dropIfExists('departments');
            Schema::dropIfExists('driver_change');
            Schema::dropIfExists('trip_material');
            Schema::dropIfExists('daily_km_calculation');
            Schema::dropIfExists('vehicle_requests_parmanently');
            Schema::dropIfExists('vehicles_detail');
            Schema::dropIfExists('giving_back_vehicle_parmanently');
            Schema::dropIfExists('trip_person');
            Schema::dropIfExists('vehicle_inspections');


        }
}