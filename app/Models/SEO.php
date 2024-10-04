<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SEO extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'keywords',
        'follow_type',
        'sociale',
        'params',
        'seo_model_id',
        'seo_model_type',
    ];

    protected $casts = [
        'sociale' => 'json',
        'params' => 'json',
    ];

    /**
     * Define a relação morphTo para seo_model.
     * Isso conecta entradas de SEO a outros modelos como Product.
     */
    public function seo_model()
    {
        return $this->morphTo();
    }
}
