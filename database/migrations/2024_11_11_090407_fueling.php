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
        //
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
            $table->integer('year')->nullable();
            $table->string('month');
            $table->integer('fuel_amount');
            $table->decimal('fuel_cost', 8, 2);
            $table->string('reciet_attachment');
            $table->timestamps();
            $table->softDeletes();
            // Add a unique constraint on the combination of fueling_id and month
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
