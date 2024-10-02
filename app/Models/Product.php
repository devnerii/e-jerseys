<?php

namespace App\Models;

use _34ML\SEO\Traits\SeoSiteMapTrait;
use _34ML\SEO\Traits\SeoTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    use SeoSiteMapTrait, SeoTrait;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'images',
        'description',
        'price',
        'price_full',
        'is_active',
        'in_stock',
        'is_featured',
        'on_sale',
        'properties',
        'variants',
        'variant_properties',
        'show_on_main_page',
        'videos',
        'gifs',
        'quantity_discounts',
        'home_page_id'
    ];

    protected $casts = [
        'images' => 'array',
        'properties' => 'array',
        'variants' => 'array',
        'variant_properties' => 'array',
        'videos' => 'array',
        'gifs' => 'array',
        'quantity_discounts' => 'array',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function getSitemapItemUrl(): string
    {
        return url($this->slug);
    }

    public static function getSitemapItems()
    {
        return static::all();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function homepage()
    {
        return $this->belongsTo(Homepage::class, 'home_page_id');
    }

}
