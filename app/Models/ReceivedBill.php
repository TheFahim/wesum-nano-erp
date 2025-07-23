<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceivedBill extends Model
{

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
