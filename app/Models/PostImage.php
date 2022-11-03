<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'post_image_id';
    public $incrementing = false;
    protected $keyType = 'string';
   
}
