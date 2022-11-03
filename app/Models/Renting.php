<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renting extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'renting_id';
    public $incrementing = false;
    protected $keyType = 'string';
   
}
