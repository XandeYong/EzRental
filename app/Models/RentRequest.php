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
   
    public static $tableName = 'rent_requests';
    public static $idCode = 'RR';
    public static $idColumn = 'rent_request_id';

}
