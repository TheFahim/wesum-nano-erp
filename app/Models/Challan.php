<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challan extends Model
{
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
}
