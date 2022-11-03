<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentRequest extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'rent_request_id';
    public $incrementing = false;
    protected $keyType = 'string';
   
}
