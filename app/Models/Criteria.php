<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $primaryKey = 'criteria_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $tableName = 'criterias';
    public static $idCode = 'CTR';
    public static $idColumn = 'criteria_id';

}
