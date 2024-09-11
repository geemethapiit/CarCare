<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Specify the table name if it's not the default plural of the class name
    protected $table = 'feedback';

    // Define which attributes can be mass assigned
    protected $fillable = [
        'ServiceTypeId',
        'BranchID',
        'rating',
        'description',
        'user_id',
    ];

    // Define the relationships to other models if needed

    /**
     * Get the service associated with the feedback.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'ServiceTypeId', 'ServiceTypeId');
    }

    /**
     * Get the branch associated with the feedback.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'BranchID', 'BranchID');
    }

    /**
     * Get the user who submitted the feedback.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
