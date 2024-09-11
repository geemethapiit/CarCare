<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'service';

    // The primary key for the model
    protected $primaryKey = 'ServiceTypeId';

    // Disable the default timestamps
    public $incrementing = false;
    protected $keyType = 'string';

    // Mass assignable attributes
    protected $fillable = [
        'ServiceTypeId',
        'ServiceTypeName',
    ];

    // Define the inverse relationship with the SubService model
    public function subServices()
    {
        return $this->hasMany(SubService::class, 'ServiceTypeId', 'ServiceTypeId');
    }
}
