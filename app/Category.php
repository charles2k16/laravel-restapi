<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Category extends Model
{
  protected $fillable = [
    'name',
    'description',
  ];

  public function products() {
    return $this->belongsToMany(Product::class);
  }
}
