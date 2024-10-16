<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'label',
        'link_type',
        'link_slug',
        'is_active',
    ];

    public function homepage()
    {
        return $this->belongsTo(Homepage::class, 'home_page_id');
    }
}
