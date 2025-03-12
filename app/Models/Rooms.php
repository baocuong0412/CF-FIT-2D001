<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function newType()
    {
        return $this->belongsTo(NewType::class, 'new_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    public function images()
    {
        return $this->hasMany(RoomImages::class, 'room_id');
    }
}
