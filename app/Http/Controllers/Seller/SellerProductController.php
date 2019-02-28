<?php

namespace App\Http\Controllers\Seller;

use App\Seller;
use App\User;
use App\Product;
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
    $product = $seller->products;
    return ['Products' => $product];
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, User $seller)
  {
    $rules = [
      'name' => 'required',
      'description' => 'required',
      'quantity' => 'required|integer|min:1',
      'image' => 'required|image',
    ];
    $this->validate($request, $rules);

    $data = $request->all();
    $data['status'] = Product::UNAVAILABLE_PRODUCT;
    $data['image'] = 'infinix.jpg';
    $data['seller_id'] = $seller->id;

    $product = Product::create($data);
    return ['Product' => $product];
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Seller  $seller
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Seller $seller, Product $product)
  {
    $rules = [
      'quantity' => 'integer|min:1',
      'status' => 'in:' . Product::AVAILABLE_PRODUCT . ',' . Product::UNAVAILABLE_PRODUCT,
      'image' => 'image',
    ];
    $this->validate($request, $rules);
    $this->checkSeller($seller, $product);

    $product->fill($request->intersect([
      'name', 'description', 'quantity',
    ]));

    if ($request->has('status')) {
      $product->status = $request->status;
    
      if ($product->isAvailable() && $product->categories()->count() == 0) {
        return ['Error' => 'An Available product must have an least one category'];
      }
    }

    $product->save();
    return ['data' => $product];
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Seller  $seller
   * @return \Illuminate\Http\Response
   */
  public function destroy(Seller $seller, Product $product)
  {
    // $this->checkSeller($seller, $product);
    $product->delete();

    return ['data' => 'Product deleted succesfully'];
  }

  protected function checkSeller(Seller $seller, Product $product) {
    if ($seller->id != $product->seller_id) {
      throw new HttpException(422, 'the specigid fjjjef fff');
      // return ['Error' => 'The specified seller is not the actuall seller of the product'];
    }
  }
}
