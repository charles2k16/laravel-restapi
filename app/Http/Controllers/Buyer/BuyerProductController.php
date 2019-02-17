<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Buyer $buyer)
  {
    // Because a buyer has many transactions it returns a set of trans.
    // $products = $buyer->transactions->product;
    $products = $buyer->transactions()->with('product')->get()->pluck('product');  // returns list of trans with products.
    return ['Buyers Product' => $products];
  }
}
