<?php

namespace App;
use App\Transaction;
use App\Http\Controllers\Buyer\BuyerScope;

class Buyer extends User
{
  // The global scope will help us differentiate a buyer from a normal user from our route response.
  protected static function boot() {
    parent::boot();
    static::addGlobalScope(new BuyerScope);
  }

  public function transactions() {
    return $this->hasMany(Transaction::class);
  }
}
