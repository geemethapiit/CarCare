<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'products';

    // Specify the primary key if it's not the default 'id'
    protected $primaryKey = 'id';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'product_name',
        'price',
        'ServiceTypeId',
    ];

    // Define relationships if needed
    public function service()
    {
        return $this->belongsTo(Service::class, 'ServiceTypeId', 'ServiceTypeId');
    }
}

