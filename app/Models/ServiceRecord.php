<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRecord extends Model
{
    use HasFactory;

    protected $table = 'service_records';

    protected $primaryKey = 'serviceRecId';

    protected $fillable = [
        'vehicle_number',
        'date',
        'time',
        'supervisor',
        'current_mileage',
        'engine_oil',
        'engine_oil_change_mileage',
        'clutch_oil',
        'clutch_oil_change_mileage',
        'brake_oil',
        'brake_oil_change_mileage',
        'coolant',
        'coolant_change_mileage',
        'oil_filter',
        'oil_filter_change_mileage',
        'power_steering_fluid',
        'power_steering_fluid_mileage',
        'air_filter',
        'air_filter_change_mileage',
        'fuel_filter',
        'fuel_filter_change_mileage',
        'ac_filter',
        'ac_filter_change_mileage',
        'gear_oil',
        'gear_oil_change_mileage',
        'chassis_lubrication',
        'chassis_lubrication_change_mileage',
        'differential_oil',
        'differential_oil_change_mileage',
        'tire_rotation',
        'tire_rotation_change_mileage',
        'wheel_alignment',
        'wheel_alignment_mileage',
        'tire_balancing',
        'tire_balancing_change_mileage',
        'flat_tire_repair',
        'tire_replacement',
        'tire_replacement_mileage',
        'wheel_rim_inspection',
        'tpms',
        'battery_replacement',
        'battery_terminal_cleaning',
        'alternator_testing',
        'starter_motor_testing',
        'electrical_wiring_inspection',
        'headlight_taillight_replacement',
        'fuse_relay_replacement',
        'exterior_car_wash',
        'interior_vacuuming',
        'engine_bay_cleaning',
        'waxing_polishing',
        'interior_detailing',
        'window_cleaning_tinting',
        'odor_removal_air_purification',
        'washing_solvent_refill',
        'wiper_blade_replacement',
        'brake_system_repair',
        'brake_system_repair_mileage',
        'suspension_repair',
        'suspension_repair_mileage',
        'exhaust_system_repair',
        'cooling_system_repair',
        'cooling_system_repair_mileage',
        'transmission_repair',
        'transmission_repair_mileage',
        'steering_system_repair',
        'steering_system_repair_mileage',
        'engine_repair',
        'radiator_cap_replacement',
        'radiator_hoses_replacement',
        'radiator_hoses_replacement_mileage'
    ];

    // You can add relationships here if needed

    // Optionally, you can define any custom methods or accessors
}
