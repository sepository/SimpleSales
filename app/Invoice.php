<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_id', 'invoice_no', 'invoice_date', 'payment_due_date', 'remarks'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function items()
    {
        return $this->hasMany('App\InvoiceItem');
    }
}
