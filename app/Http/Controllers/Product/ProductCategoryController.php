<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Product $product)
  {
    $categories = $product->categories;
    return ['Category' => $categories];
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Product $product, Category $category)
  {
    // add a category to a product
    // attach, sync, syncWithoutDetaching
    $product->categories()->syncWithoutDetaching([$category->id]);

    return ['Category' => $product->categories];
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function destroy(Product $product, Category $category)
  {
    if (!$product->categories()->find($category->id)) {
      return ['Error' => 'Category is not available'];
    }

    $product->categories()->detach($category->id);
    return ['Category' => $product->categories];
  }
}
