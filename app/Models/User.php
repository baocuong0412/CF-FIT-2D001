<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            do {
                $payCode = 'PAY-CODE-' . mt_rand(100000, 999999);
            } while (User::where('pay_code', $payCode)->exists());

            $user->pay_code = $payCode;
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rooms()
    {
        return $this->hasMany(Rooms::class, 'user_id');
    }

    public function depositMoney()
    {
        return $this->hasMany(DepositMoney::class, 'user_id');
    }

    public function paymentHistory()
    {
        return $this->hasMany(PaymentHistory::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'user_id');
    }

    public function reply() {
        return $this->hasMany(Replies:: class, 'user_id ');
    }
}
