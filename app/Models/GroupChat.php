<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupChat extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'group_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $tableName = 'group_chats';
    public static $idCode = 'GC';
    public static $idColumn = 'group_id';
   

    public function messages() {
        return $this->hasMany(GroupMessage::class, 'group_id');
    }
}
