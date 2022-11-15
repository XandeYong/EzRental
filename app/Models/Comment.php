<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'comment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function owner() {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function post() {
        return $this->belongsTo(RoomRentalPost::class, 'post_id');
    }
   
}
