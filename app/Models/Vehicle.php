<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'vehicle_number'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 
    
    protected $fillable = [
        'vehicle_number',
        'vehicle_image',
        'model',
        'year',
        'user_id',
        'vehicle_book_image', 
        'status', 
    ];

    public function user()
    {

    return $this->belongsTo(User::class, 'user_id'); 

    }
}
