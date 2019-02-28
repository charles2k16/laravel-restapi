<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Buyers
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);
Route::resource('buyers.transactions', 'Buyer\BuyerTransController', ['only' => ['index']]);
Route::resource('buyers.products', 'Buyer\BuyerProductController', ['only' => ['index']]);
Route::resource('buyers.sellers', 'Buyer\BuyerSellerController', ['only' => ['index']]);

//Categories 
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
Route::resource('categories.products', 'Category\CategoryProductController', ['only' => ['index']]);

//Prodcuts 
Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);
Route::resource('products.transaction', 'Product\ProductTransController', ['only' => ['index']]);
Route::resource('products.category', 'Product\ProductCategoryController', ['only' => ['index', 'update', 'destroy']]);
Route::resource('products.buyers.transactions', 'Product\ProductBuyerTransController', ['only' => ['store']]);

//Sellers 
Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);
Route::resource('sellers.transactions', 'Seller\SellerTransController', ['only' => ['index']]);
Route::resource('sellers.products', 'Seller\SellerProductController', ['except' => ['create', 'show', 'edit']]); //error for update

//Transaction
Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);
Route::resource('transactions.products', 'Transaction\TransactionProductController', ['only' => ['index']]);

//Users
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);