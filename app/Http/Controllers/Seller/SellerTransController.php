<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerTransController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Seller $seller)
  {
    $transactions = $seller->products()->with('transactions')
      ->get()->pluck('transactions')->collapse();

    return ['Transaction' => $transactions];
  }
}
