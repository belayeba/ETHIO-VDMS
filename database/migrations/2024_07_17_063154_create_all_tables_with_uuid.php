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
            $table->timestamps();
        });
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid('department_id')->primary();
            $table->string('name', 255);
            $table->uuid('cluster_id');
            $table->foreign('cluster_id')->references('cluster_id')->on('clusters');
            $table->timestamps();
        });
        
           // Drivers Table
           Schema::create('drivers', function (Blueprint $table) {
            $table->uuid('driver_id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('license_number', 255);
            $table->date('license_expiry_date');
            $table->string('status', 255)->default('active');
            $table->string('phone_number', 15)->nullable();
            $table->uuid('register_by');
            $table->foreign('register_by')->references('id')->on('users');
            $table->text('notes')->nullable();
            $table->timestamps();
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
            $table->string('vehicle_category', 255);
            $table->decimal('fuel_amount', 10, 2);
            $table->date('last_service')->nullable();
            $table->date('next_service')->nullable();
            $table->uuid('driver_id')->nullable();
            $table->foreign('driver_id')->references('driver_id')->on('drivers');
            $table->string('fuel_type', 255);
            $table->string('status', 255);
            $table->text('notes')->nullable();
            $table->timestamps();
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
        });

        // Maintenance Table
        Schema::create('maintenance', function (Blueprint $table) {
            $table->uuid('maintenance_id')->primary();
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
            $table->uuid('requested_by');
            $table->foreign('requested_by')->references('id')->on('users');
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->string('maintenance_type', 255);
            $table->uuid('maintained_by')->nullable();
            $table->foreign('maintained_by')->references('id')->on('users');
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->integer('mileage')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->text('parts_used')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Fueling Table
        Schema::create('fueling', function (Blueprint $table) {
            $table->uuid('fueling_id')->primary();
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
            $table->uuid('driver_id');
            $table->foreign('driver_id')->references('driver_id')->on('drivers');
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->date('fuiling_date')->nullable();
            $table->uuid('service_given_by')->nullable();
            $table->foreign('service_given_by')->references('id')->on('users');
            $table->integer('mileage')->nullable();
            $table->decimal('fuel_amount', 10, 2)->nullable();
            $table->decimal('fuel_cost', 10, 2)->nullable();
            $table->uuid('location_id')->nullable();
            $table->foreign('location_id')->references('location_id')->on('locations');
            $table->text('notes')->nullable();
            $table->timestamps();
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
            $table->integer('start_km')->nullable();
            $table->integer('end_km')->nullable();
            $table->string('status', 255)->default('Pending');
            $table->uuid('assigned_vehicle_id')->nullable();
            $table->foreign('assigned_vehicle_id')->references('vehicle_id')->on('vehicles');
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->uuid('assigned_by')->nullable();
            $table->foreign('assigned_by')->references('id')->on('users');
            $table->string('start_location_id', 255);
            $table->string('end_location_id', 255);
            $table->decimal('allowed_distance_after_destination', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->string('comment', 255)->nullable();
            $table->decimal('km_per_liter', 10, 2)->nullable();
            $table->uuid('driver_accepted_by')->nullable();
            $table->foreign('driver_accepted_by')->references('id')->on('users');
            $table->timestamps();
        });

        // Notifications Table
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('notification_id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('message');
            $table->string('status', 255)->default('Unread');
            $table->timestamps();
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
        });

        // Service Employee Table
        Schema::create('service_employee', function (Blueprint $table) {
            $table->uuid('service_employee_id')->primary();
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('phone_number', 255)->unique();
            $table->timestamps();
        });


         // Driver Logs Table
        Schema::create('daily_km_calculation', function (Blueprint $table) {
            $table->uuid('km_calculation_id')->primary();
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
        });
         // Driver Logs Table
         Schema::create('vehicle_requests_parmanently', function (Blueprint $table) {
            $table->uuid('request_id')->primary();
            $table->uuid('requested_by');
            $table->foreign('requested_by')->references('id')->on('users');
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->uuid('given_by')->nullable();
            $table->foreign('given_by')->references('id')->on('users');
            $table->date('given_date')->nullable();
            $table->uuid('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
            $table->integer('mileage')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
          // Vehicle Detail
          Schema::create('vehicle_detail', function (Blueprint $table) {
            $table->uuid('detail_id')->primary();
            $table->string('damage', 1000)->default('Unread');
            $table->uuid('register_by');
            $table->foreign('register_by')->references('id')->on('users');
            $table->date('date');
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
            $table->integer('mileage');
            $table->uuid('driver_id');
            $table->foreign('driver_id')->references('driver_id')->on('drivers');
            $table->timestamps();
        });
         // Giving back Permanent Vehicle Request 
         Schema::create('giving_back_vehicle_parmanently', function (Blueprint $table) {
            $table->uuid('request_id')->primary();
            $table->uuid('requested_by');
            $table->foreign('requested_by')->references('id')->on('users');
            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->uuid('accepted_by')->nullable();
            $table->foreign('accepted_by')->references('id')->on('users');
            $table->date('returned_date')->nullable();
            $table->uuid('vehicle_detail_id')->nullable();
            $table->foreign('vehicle_detail_id')->references('detail_id')->on('vehicle_detail');
            $table->integer('mileage')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
          // trip person
          Schema::create('trip_person', function (Blueprint $table) {
            $table->uuid('trip_person_id')->primary();
            $table->uuid('request_id');
            $table->foreign('request_id')->references('request_id')->on('vehicle_requests_temporary');
            $table->uuid('employee_id');
            $table->foreign('employee_id')->references('id')->on('users');
            $table->timestamps();
        });
        // driver change
        Schema::create('driver_change', function (Blueprint $table) {
            $table->uuid('driver_change_id')->primary();
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
            $table->uuid('new_driver_id');
            $table->foreign('new_driver_id')->references('id')->on('users');
            $table->uuid('old_driver_id');
            $table->foreign('old_driver_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('maintenance');
        Schema::dropIfExists('fueling');
        Schema::dropIfExists('gps_tracking');
        Schema::dropIfExists('driver_logs');
        Schema::dropIfExists('vehicle_requests_temporary');
       
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('driver_communications');
        Schema::dropIfExists('service_employee');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('driver_change');
        Schema::dropIfExists('daily_km_calculation');
        Schema::dropIfExists('vehicle_requests_parmanently');
        Schema::dropIfExists('vehicle_detail');
        Schema::dropIfExists('giving_back_vehicle_parmanently');
        Schema::dropIfExists('trip_person');

    }
}

