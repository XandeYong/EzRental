<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renting extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'renting_id';
    public $incrementing = false;
    protected $keyType = 'string';
   
    public static $tableName = 'rentings';
    public static $idCode = 'R';
    public static $idColumn = 'renting_id';

    protected $fillable = [
        'renting_id', 'account_id', 'post_id', 'contract_id', 'status', 'renew_contract'
    ];

    public function post() {
        return $this->belongsTo(RoomRentalPost::class, 'post_id');
    }

}
