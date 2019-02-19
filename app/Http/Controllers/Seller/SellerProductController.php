<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Seller $seller)
  {
    $products = $seller->products;
    return ['Products' => $products];
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Seller  $seller
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Seller $seller)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Seller  $seller
   * @return \Illuminate\Http\Response
   */
  public function destroy(Seller $seller)
  {
      //
  }
}
