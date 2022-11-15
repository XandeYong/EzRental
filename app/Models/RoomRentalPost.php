<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomRentalPost extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'post_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function owner() {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function contracts() {
        return $this->hasMany(Contract::class, 'post_id');
    }

    public function images() {
        return $this->hasMany(PostImage::class, 'post_id');
    }

    public function criterias() {
        return $this->hasManyThrough(
            Criteria::class, PostCriteria::class,
            'post_id', 'criteria_id',
            'post_id', 'criteria_id'
        );
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'post_id');
    }
   
}
