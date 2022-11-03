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
   
}
