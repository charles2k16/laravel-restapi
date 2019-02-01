<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Buyer;
use App\Product;

class Transaction extends Model
{
  protected $fillable = [
    'quantity',
    'buyer_id',
    'product_id',
  ];

  public function buyer() {
    return $this->belongsTo(Buyer::class);
  }

  public function product() {
    return $this->belongsTo(Prodcut::class);
  }
}
