<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $primaryKey = ['invoice_id', 'item_id'];

    public $incrementing = false;

    protected $fillable = [
        'invoice_id', 'item_id', 'product_id', 'quantity', 'amount', 'remarks'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
