<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = 'wards';

    protected $guarded = [];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function rooms()
    {
        return $this->hasMany(Rooms::class, 'ward_id');
    }
}
