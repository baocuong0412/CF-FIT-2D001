<?php

namespace App\Models;  

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;  
use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  
use Illuminate\Auth\Authenticatable;  

class Admin extends Model implements AuthenticatableContract  
{  
    use HasFactory, Authenticatable; // Kết hợp trait Authenticatable  

    protected $table = 'admin';  

    protected $guarded = [];  

    public function new() {
        return $this->hasMany(News::class, 'admin_id');
    }
}  