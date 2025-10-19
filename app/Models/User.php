<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\PasswordReset;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_group_id', 'active', 'avatar'
    ];

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

    /**
     * User group
     *
     * @return type
     */
    public function userGroup()
    {
        return $this->belongsTo('App\Models\UserGroup');
    }

    /**
     * Customer
     *
     * @return type
     */
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
	
	
	 /**
     * Venodr
     *
     * @return type
     */
    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }

    /**
     * Setting
     *
     * @return void
     */
    public function setting()
    {
        return $this->hasOne('App\Models\Setting');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }
}
