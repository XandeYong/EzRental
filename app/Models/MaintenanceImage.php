<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceImage extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'maintenance_image_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $tableName = 'maintenance_images';
    public static $idCode = 'MI';
    public static $idColumn = 'maintenance_image_id';
   
}
