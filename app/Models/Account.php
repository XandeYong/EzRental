<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $primaryKey = 'account_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function contracts() {
        return $this->hasManyThrough(
            Contract::class, RoomRentalPost::class,
            'account_id', 'post_id',
            'account_id', 'post_id'
        );
    }
    
}
