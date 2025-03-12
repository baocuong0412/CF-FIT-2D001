<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImages extends Model
{
    use HasFactory;

    protected $table = 'room_image';

    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }
}
