<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'sub_services';

    // The primary key for the model
    protected $primaryKey = 'SubServiceId';

    // Disable the default timestamps
    public $incrementing = false;
    protected $keyType = 'string';

    // Mass assignable attributes
    protected $fillable = [
        'SubServiceId',
        'SubServiceName',
        'ServiceTypeId',
    ];

    // Define the relationship with the Service model
    public function service(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Service::class, 'ServiceTypeId', 'ServiceTypeId');
    }
}
