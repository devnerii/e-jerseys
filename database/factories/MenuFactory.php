<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $section = fake()->randomElement(['header', 'footer_1', 'footer_2', 'footer_3']);
        $link_type = fake()->randomElement(['none', 'external', 'product', 'category'/*, 'page'*/]);
        $label = fake()->sentence(3);
        $link_slug = fake()->slug();

        if ($link_type == 'none') {
            $link_slug = null;
        } elseif ($link_type == 'external') {
            $link_slug = fake()->url();
        } elseif ($link_type == 'product') {
            $product = Product::inRandomOrder()->first();
            $link_slug = $product->slug;
            $label = $product->name;
        } elseif ($link_type == 'category') {
            $category = Category::inRandomOrder()->first();
            $link_slug = $category->slug;
            $label = $category->name;
        }

        return [
            'section' => $section,
            'label' => $label,
            'link_type' => $link_type,
            'link_slug' => $link_slug,
            'is_active' => fake()->boolean($chanceOfGettingTrue = 90),
        ];
    }
}
