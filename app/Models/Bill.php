<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function challan()
    {
        return $this->belongsTo(Challan::class);
    }

    public function receivedBills()
    {
        return $this->hasMany(ReceivedBill::class);
    }
}
