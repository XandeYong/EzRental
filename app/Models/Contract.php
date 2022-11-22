<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'contract_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public static $tableName = 'contracts';
    public static $idCode = 'CT';
    public static $idColumn = 'contract_id';

    public function post() {
        return $this->belongsTo(RoomRentalPost::class, 'post_id');
    }
   
}
