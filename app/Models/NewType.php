<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewType extends Model
{   
    use HasFactory;

    protected $table = 'new_type';

    protected $guarded = [];

    public function rooms()
    {
        return $this->hasMany(Rooms::class, 'new_type_id');
    }

    public function PaymentHistories()
    {
        return $this->hasMany(PaymentHistory::class, 'new_type_id');
    }
}
