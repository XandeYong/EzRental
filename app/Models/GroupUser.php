<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    use HasFactory;

    public function groupChats() {
        return $this->belongsToMany(GroupChat::class, 'group_id');
    }
}
