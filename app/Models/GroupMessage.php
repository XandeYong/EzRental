<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'group_message_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $tableName = 'group_messages';
    public static $idCode = 'GM';
    public static $idColumn = 'group_message_id';
   
}
