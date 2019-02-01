<?php

namespace App;
use App\Product;

class Seller extends User
{
    public function product() {
        return $this->hasMany(Product::class);
    }
}
