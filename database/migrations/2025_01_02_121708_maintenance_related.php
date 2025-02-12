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
         // Maintenance Table
         Schema::create('maintenances', function (Blueprint $table) {
            $table->uuid('maintenance_id')->primary();
            $table->uuid('vehicle_id');
            $table->foreign('vehicle_id')->references('vehicle_id')->on('vehicles')->onDelete('restrict');
            $table->uuid('requested_by');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('restrict');
            
            $table->string('drivers_inspection')->nullable();


            $table->string('milage');
            $table->enum('maintenance_type', ['service','accident']);
            $table->enum('maintenance_status', ['in_progress','completed','simirit_approved','pending','rejected'])->default('pending');

            $table->uuid('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('approver_rejection_reason', 1000)->nullable();

            $table->uuid('inspected_by')->nullable();
            $table->foreign('inspected_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('inspector_comment', 1000)->nullable();
            $table->string('car_inspector_inspection')->nullable();

            $table->uuid('sim_approved_by')->nullable();
            $table->foreign('sim_approved_by')->references('id')->on('users')->onDelete('restrict');
            $table->string('simirit_reject_reason', 1000)->nullable();

            $table->uuid('inspection_id')->nullable();
            $table->uuid('part_name')->nullable();
            $table->uuid('inspection_by')->nullable();
            
            // More descriptive foreign key name
            $table->foreign(['inspection_id', 'part_name', 'inspection_by'], 'fk_inspection_details')
                ->references(['inspection_id', 'part_name', 'inspected_by'])
                ->on('vehicle_inspections')
                ->onDelete('restrict');

            // $table->uuid('taking_inspection')->nullable();
            // $table->foreign('taking_inspection')->references('inspection_id')->on('vehicle_inspections')->onDelete('restrict');

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
     
        Schema::create('maintained_vehicles', function (Blueprint $table) {
            $table->uuid('maintained_vehicle_id')->primary();
            $table->uuid('maintenance_id');
            $table->foreign('maintenance_id')->references('maintenance_id')->on('maintenances')->onDelete('cascade');

            $table->uuid('inspection_id')->nullable();
            $table->uuid('part_name')->nullable();
            $table->uuid('inspection_by')->nullable();

            // More descriptive foreign key name
            $table->foreign(['inspection_id', 'part_name', 'inspection_by'], 'fk_inspection_detail')
                ->references(['inspection_id', 'part_name', 'inspected_by'])
                ->on('vehicle_inspections')
                ->onDelete('restrict');
            
            // $table->uuid('giving_inspection')->nullable();
            // $table->foreign('giving_inspection')->references('inspection_id')->on('vehicle_inspections')->onDelete('restrict');
            $table->string('spareparts_used')->nullable();
            $table->uuid('accepted_by')->nullable();
            $table->foreign('accepted_by')->references('id')->on('users')->onDelete('restrict');
            $table->text('card_number')->nullable(); 
            $table->text('technician_description')->nullable(); 
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('items_for_next_maintenances',function (Blueprint $table){
            $table->uuid('items_for_next_maintenance_id')->primary();
            $table->uuid('maintained_vehicle_id');
            $table->foreign('maintained_vehicle_id')->references('maintained_vehicle_id')->on('maintained_vehicles')->onDelete('cascade');
    
            $table->string('part_type', 255);          
            $table->string('measurment');          
            $table->string('quantity');          
            $table->string('part_no');          
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('total_maintenance_costs',function (Blueprint $table){
            $table->uuid('total_maintenance_cost_id')->primary();
            $table->uuid('maintained_vehicle_id');
            $table->foreign('maintained_vehicle_id')->references('maintained_vehicle_id')->on('maintained_vehicles')->onDelete('cascade');
            $table->string('sparepart_cost', 255);          
            $table->string('machine_cost');          
            $table->string('labor_cost');          
            $table->string('total_cost');          
            $table->timestamps();
            $table->softDeletes();
        });

     Schema::create('maintenance_records',function (Blueprint $table){
        $table->uuid('maintenance_record_id')->primary();
        $table->uuid('maintained_vehicle_id');
        $table->foreign('maintained_vehicle_id')->references('maintained_vehicle_id')->on('maintained_vehicles')->onDelete('cascade');
        $table->dateTime('maintenance_start_date');
        $table->dateTime('maintenance_end_date')->nullable();
        $table->string('completed_task');          
        $table->string('time_elapsed');
        $table->uuid('maintained_by');
        $table->foreign('maintained_by')->references('id')->on('users')->onDelete('restrict');
        $table->timestamps();
        $table->softDeletes();   
           });
      
        Schema::create('amount_of_nezek_useds',function (Blueprint $table)
        {
        $table->uuid('amount_of_nezek_used_id')->primary();
        $table->uuid('maintained_vehicle_id');
        $table->foreign('maintained_vehicle_id')->references('maintained_vehicle_id')->on('maintained_vehicles')->onDelete('cascade');
        $table->string('amount_of_nezek', 255);
        $table->string('type_of_nezek', 255);
        $table->timestamps();
        $table->softDeletes();
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
