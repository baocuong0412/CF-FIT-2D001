<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory; 
    
    protected $table = 'categories';

    protected $guarded = [];

    public function rooms()
    {
        return $this->hasMany(Rooms::class, 'category_id');
    }
}
