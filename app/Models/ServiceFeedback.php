<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFeedback extends Model
{
    use HasFactory;

    protected $table = 'service_feedback';

    // The attributes that are mass assignable.
    protected $fillable = [
        'ServiceTypeId',
        'BranchId',
        'rating',
        'description',
    ];

    // Define relationships if needed
    public function service()
    {
        return $this->belongsTo(Service::class, 'ServiceTypeId', 'ServiceTypeId');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'BranchID', 'BranchId');
    }
}
