<?php

namespace App\Models;

use App\Models\Resource;
use App\Models\Technology;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function technology()
    {
        return $this->belongsTo(Technology::class);
    }

}
