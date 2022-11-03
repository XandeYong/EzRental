<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitAppointment extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'appointment_id';
    public $incrementing = false;
    protected $keyType = 'string';
   
}
