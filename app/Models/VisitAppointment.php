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

    public static $tableName = 'visit_appointments';
    public static $idCode = 'VA';
    public static $idColumn = 'appointment_id';

    protected $fillable = [
        'appointment_id', 'datetime', 'note', 'status', 'post_id', 'account_id'
    ];
   
}
