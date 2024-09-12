<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $primaryKey = 'AppointmentID';

    protected $fillable = [
        'date',
        'time',
        'status',
        'ServiceTypeId',
        'BranchID',
        'vehicle_number',
        'user_id',
    ];

    public function serviceType()
    {
        return $this->belongsTo(Service::class, 'ServiceTypeId');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'BranchID');
    }

}
