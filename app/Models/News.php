<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'new';  

    protected $guarded = [];  

    public function admin(){
        return $this->belongsTo(Admin::class, 'admim_id');
    }

}
