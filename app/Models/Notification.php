<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'notification_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $tableName = 'notifications';
    public static $idCode = 'NTF';
    public static $idColumn = 'notification_id';
   
}
