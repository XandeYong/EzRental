<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'maintenance_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $tableName = 'maintenance_requests';
    public static $idCode = 'MR';
    public static $idColumn = 'maintenance_id';
   
}
