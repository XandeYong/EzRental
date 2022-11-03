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
   
}
