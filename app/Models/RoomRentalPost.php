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

    public static $tableName = 'room_rental_posts';
    public static $idCode = 'RRP';
    public static $idColumn = 'post_id';

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

    public function rentings() {
        return $this->hasMany(Renting::class, 'post_id');
    }
   
}
