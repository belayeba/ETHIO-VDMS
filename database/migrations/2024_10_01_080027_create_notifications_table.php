<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('notification_id')->primary(); // Use UUID as primary key
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
        Schema::create('Parmanent_fuelings', function (Blueprint $table) {
            $table->uuid('fueling_id')->primary();
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles');
            $table->uuid('driver_id');
            $table->foreign('driver_id')->references('driver_id')->on('drivers');
            $table->uuid('finance_approved_by')->nullable();
            $table->foreign('finance_approved_by')->references('id')->on('users');
            $table->uuid('permanent_id')->nullable();
            $table->foreign('permanent_id')->references('vehicle_request_permanent_id')->on('vehicle_requests_parmanently');
            $table->string('reject_reason')->nullable();
            $table->date('fuiling_date');
            $table->string('month');
            $table->integer('fuel_amount');
            $table->double('fuel_cost');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('Parmanent_fuelings');

    }
};
