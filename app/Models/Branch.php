<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'branches';

    // Specify the primary key if it's not the default 'id'
    protected $primaryKey = 'BranchID';

    // If the primary key is not auto-incrementing, specify this
    public $incrementing = false;

    // Define which attributes are mass assignable
    protected $fillable = ['BranchID', 'name', 'address', 'telephone'];
}
