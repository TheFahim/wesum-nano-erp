<?php

namespace App\Models;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'users_technologies');
    }

}
