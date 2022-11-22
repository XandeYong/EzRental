<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'message_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $tableName = 'chat_messages';
    public static $idCode = 'CM';
    public static $idColumn = 'message_id';
   
}
