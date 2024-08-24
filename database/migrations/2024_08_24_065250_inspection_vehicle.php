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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('vehicle_inspections');
        Schema::dropIfExists('vehicle_parts');
    }
};
