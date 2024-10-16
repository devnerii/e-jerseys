<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    private $fake_banners = [
        0 => [
            'image_lg' => 'banners/banner_1_web.webp',
            'image_sm' => 'banners/banner_1_mobile.webp',
        ],
        1 => [
            'image_lg' => 'banners/banner_2_web.webp',
            'image_sm' => 'banners/banner_2_mobile.webp',
        ],
        2 => [
            'image_lg' => 'banners/banner_3_web.webp',
            'image_sm' => 'banners/banner_3_mobile.webp',
        ],
        3 => [
            'image_lg' => 'banners/banner_4_web.webp',
            'image_sm' => 'banners/banner_4_mobile.webp',
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $banner = fake()->randomElement($this->fake_banners);

        $link_type = fake()->randomElement(['none', 'external', 'product', 'category'/*, 'page'*/]);

        $link_slug = fake()->slug();

        if ($link_type == 'none') {
            $link_slug = null;
        } elseif ($link_type == 'external') {
            $link_slug = fake()->url();
        } elseif ($link_type == 'product') {
            $link_slug = Product::inRandomOrder()->first()->slug;
        } elseif ($link_type == 'category') {
            $link_slug = Category::inRandomOrder()->first()->slug;
        }

        return [
            'image_lg' => $banner['image_lg'],
            'image_sm' => $banner['image_sm'],
            'link_type' => $link_type,
            'link_slug' => $link_slug,
            'is_active' => fake()->boolean($chanceOfGettingTrue = 90),
        ];
    }
}
