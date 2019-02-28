<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\User;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductBuyerTransController extends Controller
{
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, Product $product, User $buyer)
  {
    $rules = [
      'quantity' => 'required|integer|min:1'
    ];

    // if the buyer is different from the seller since they are both users.
    if ($buyer->id == $product->seller_id) {
      return ['Error' => 'The buyer must be different from the seller'];
    }

    // if both seller and buyer are verified users
    if (!$buyer->isVerified()) {
      return ['Error' => 'The buyer must be verified'];
    }

    if (!$product->seller->isVerified()) {
      return ['Error' => 'The Seller must be verified'];
    }

    if (!$product->isAvailable()) {
      return ['Error' => 'The product is not available'];
    }

    if ($product->quantity < $request->quantity) {
      return ['Error' => 'There are not enough product quantity for your order'];
    }

    return DB::transaction(function() use ($request, $product, $buyer) {
      $product->quantity -= $request->quantity;
      $product->save();

      $transaction = Transaction::create([
        'quantity' => $request->quantity,
        'buyer_id' => $buyer->id,
        'product_id' => $product->id,
      ]);
      
      return ['Transaction' => $transaction];
    });
  }
}
