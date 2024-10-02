<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'is_active', 'logo_path',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }
}
