<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_page_id',
        'image_sm',
        'image_lg',
        'link_type',
        'link_slug',
        'is_active',
        'video_path',
        'mid_page_banner',
    ];

    public function homePage()
    {
        return $this->belongsTo(HomePage::class);
    }
}
