<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanRecord extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'ban_id';
    public $incrementing = false;
    protected $keyType = 'string';
   
}
