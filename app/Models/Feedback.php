<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Specify the table name if it's not the default plural of the class name
    protected $table = 'feedback';  // Match this with the migration if 'feedback' is the table name

    // Define which attributes can be mass assigned
    protected $fillable = [
        'AppointmentID',
        'ServiceTypeId',
        'BranchID',
        'rating',
        'feedback',  // Ensure this matches the migration (change 'description' to 'feedback')
        'user_id',
    ];

    // Define relationships
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'BranchID', 'BranchID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'AppointmentID', 'AppointmentID');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'ServiceTypeId', 'ServiceTypeId');
    }
}
