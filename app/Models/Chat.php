<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'chat_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $tableName = 'chats';
    public static $idCode = 'C';
    public static $idColumn = 'chat_id';

    public function messages() {
        return $this->hasMany(ChatMessage::class, 'chat_id');
    }
   
}
