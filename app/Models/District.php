<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    protected $guarded = [];

    public function city()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }

    public function rooms()
    {
        return $this->hasMany(Rooms::class, 'district_id');
    }
}
