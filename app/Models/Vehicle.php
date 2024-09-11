<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'vehicle_number'; // Set vehicle_number as the primary key
    public $incrementing = false; // Since vehicle_number is a string, disable auto-incrementing
    protected $keyType = 'string'; // Specify the key type as string

    protected $fillable = [
        'vehicle_number',
        'model',
        'year',
        'user',
    ];

    public function user()
    {

    return $this->belongsTo(User::class, 'user'); 

    }
}
