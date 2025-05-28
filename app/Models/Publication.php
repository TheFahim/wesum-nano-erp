<?php

namespace App\Models;

use App\Models\PublicationArea;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    public function publicationArea()
    {
        return $this->belongsTo(PublicationArea::class);
    }

    // cast json to array
    protected $casts = [
        'authors' => 'array'
    ];
}
