<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleTarget extends Model
{
    protected $appends = ['from', 'to']; // Append these to JSON

    public function getFromAttribute()
    {
        return \Carbon\Carbon::create()
            ->month($this->start_month)
            ->format('M') . '-' . $this->start_year;
    }

    public function getToAttribute()
    {
        return \Carbon\Carbon::create()
            ->month($this->end_month)
            ->format('M') . '-' . $this->end_year;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
