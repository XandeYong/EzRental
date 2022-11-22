<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negotiation extends Model
{
    
    protected $primaryKey = 'negotiation_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $tableName = 'negotiations';
    public static $idCode = 'NGT';
    public static $idColumn = 'negotiation_id';
   
}
