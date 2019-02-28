<?php

namespace App\Providers;

use App\Product;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
    Schema::defaultStringLength(191);
    
    Product::updated(function ($product) {
      if ($product->quantity == 0 && $product->isAvailable()) {
        $product->status = Product::UNAVAILABLE_PRODUCT;

        $product->save();
      }
    });
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
