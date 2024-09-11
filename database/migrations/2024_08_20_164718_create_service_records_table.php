<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_records', function (Blueprint $table) {
            $table->id('serviceRecId');
            $table->string('vehicle_number');
            $table->foreign('vehicle_number')->references('vehicle_number')->on('vehicles')->onDelete('cascade');
            $table->date('date');
            $table->time('time');
            $table->string('supervisor');
            $table->foreign('supervisor')->references('name')->on('admin_users')->onDelete('cascade');
            $table->integer('current_mileage'); // Mandatory

            // Oil and Lubrication Services
            $table->string('engine_oil')->default('N/A');
            $table->integer('engine_oil_change_mileage')->nullable();
            $table->string('clutch_oil')->default('N/A');
            $table->integer('clutch_oil_change_mileage')->nullable();
            $table->string('brake_oil')->default('N/A');
            $table->integer('brake_oil_change_mileage')->nullable();
            $table->string('coolant')->default('N/A');
            $table->integer('coolant_change_mileage')->nullable();
            $table->string('oil_filter')->default('N/A');
            $table->integer('oil_filter_change_mileage')->nullable();
            $table->string('power_steering_fluid')->default('N/A');
            $table->integer('power_steering_fluid_mileage')->nullable();
            $table->string('air_filter')->default('N/A');
            $table->integer('air_filter_change_mileage')->nullable();
            $table->string('fuel_filter')->default('N/A');
            $table->integer('fuel_filter_change_mileage')->nullable();
            $table->string('ac_filter')->default('N/A');
            $table->integer('ac_filter_change_mileage')->nullable();
            $table->string('gear_oil')->default('N/A');
            $table->integer('gear_oil_change_mileage')->nullable();
            $table->string('chassis_lubrication')->default('N/A');
            $table->integer('chassis_lubrication_change_mileage')->nullable();
            $table->string('differential_oil')->default('N/A');
            $table->integer('differential_oil_change_mileage')->nullable();

            // Tire and Wheel Services
            $table->string('tire_rotation')->default('N/A');
            $table->integer('tire_rotation_change_mileage')->nullable();
            $table->string('wheel_alignment')->default('N/A');
            $table->integer('wheel_alignment_mileage')->nullable();
            $table->string('tire_balancing')->default('N/A');
            $table->integer('tire_balancing_change_mileage')->nullable();
            $table->string('flat_tire_repair')->default('N/A');
            $table->string('tire_replacement')->default('N/A');
            $table->integer('tire_replacement_mileage')->nullable();
            $table->string('wheel_rim_inspection')->default('N/A');
            $table->string('tpms')->default('N/A');

            // Battery and Electrical Services
            $table->string('battery_replacement')->default('N/A');
            $table->string('battery_terminal_cleaning')->default('N/A');
            $table->string('alternator_testing')->default('N/A');
            $table->string('starter_motor_testing')->default('N/A');
            $table->string('electrical_wiring_inspection')->default('N/A');
            $table->string('headlight_taillight_replacement')->default('N/A');
            $table->string('fuse_relay_replacement')->default('N/A');

            // Cleaning and Detailing Services
            $table->string('exterior_car_wash')->default('N/A');
            $table->string('interior_vacuuming')->default('N/A');
            $table->string('engine_bay_cleaning')->default('N/A');
            $table->string('waxing_polishing')->default('N/A');
            $table->string('interior_detailing')->default('N/A');
            $table->string('window_cleaning_tinting')->default('N/A');
            $table->string('odor_removal_air_purification')->default('N/A');
            $table->string('washing_solvent_refill')->default('N/A');
            $table->string('wiper_blade_replacement')->default('N/A');

            // Mechanical Repair Services
            $table->string('brake_system_repair')->default('N/A');
            $table->integer('brake_system_repair_mileage')->nullable();
            $table->string('suspension_repair')->default('N/A');
            $table->integer('suspension_repair_mileage')->nullable();
            $table->string('exhaust_system_repair')->default('N/A');
            $table->string('cooling_system_repair')->default('N/A');
            $table->integer('cooling_system_repair_mileage')->nullable();
            $table->string('transmission_repair')->default('N/A');
            $table->integer('transmission_repair_mileage')->nullable();
            $table->string('steering_system_repair')->default('N/A');
            $table->integer('steering_system_repair_mileage')->nullable();
            $table->string('engine_repair')->default('N/A');
            $table->string('radiator_cap_replacement')->default('N/A');
            $table->string('radiator_hoses_replacement')->default('N/A');
            $table->integer('radiator_hoses_replacement_mileage')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_records');
    }
}