<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    // 取引先
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
