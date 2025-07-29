<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, Filterable;
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'quantity',
        'stock_status',
        'featured',
        'image',
        'images',
        'sex',
        'low_stock_notified',
        'reorder_quantity',
        'outofstock_quantity',
        'category_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
}
