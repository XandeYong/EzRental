<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'payment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $tableName = 'payments';
    public static $idCode = 'P';
    public static $idColumn = 'payment_id';
   
}
