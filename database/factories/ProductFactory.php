<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    private $fake_images = [
        [
            'products/produto_1_1.webp',
            'products/produto_1_2.webp',
            'products/produto_1_3.webp',
            'products/produto_1_4.webp',
        ],
        [
            'products/produto_2_1.webp',
            'products/produto_2_2.webp',
            'products/produto_2_3.webp',
            'products/produto_2_4.webp',
        ],
        [
            'products/produto_3_1.webp',
            'products/produto_3_2.webp',
            'products/produto_3_3.webp',
            'products/produto_3_4.webp',
        ],
        [
            'products/produto_4_1.webp',
            'products/produto_4_2.webp',
            'products/produto_4_3.webp',
            'products/produto_4_4.webp',
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = fake()->randomElement($this->fake_images);
        shuffle($images);
        $on_sale = fake()->boolean();
        $price = fake()->randomFloat(2, 50, 300);
        $price_full = 0;
        if ($on_sale) {
            $price_full = $price + fake()->randomFloat(2, 10, 100);
        }
        $properties = '{}';
        $properties = json_decode($properties, true);

        $max_properties = fake()->numberBetween(0, 8);
        for ($i = 0; $i < $max_properties; $i++) {
            $properties[fake()->word()] = fake()->word();
        }
        $variant_properties = [];
        $max_variant_properties = fake()->numberBetween(0, 2);
        for ($i = 0; $i < $max_variant_properties; $i++) {
            $value_num = fake()->numberBetween(1, 5);
            $values = [];
            for ($j = 0; $j < $value_num; $j++) {
                $values[] = fake()->word();
            }
            $variant_properties[] = [
                'name' => fake()->word(),
                'values' => $values,
            ];
        }
        $variants = [];
        $variants_props = [];
        $variants_vals = [];
        foreach ($variant_properties as $variant_prop) {
            $variants_props[] = $variant_prop['name'];
            $variants_vals[$variant_prop['name']] = $variant_prop['values'];
        }
        $max_variants = fake()->numberBetween(0, 3 * count($variants_props));
        for ($i = 0; $i < $max_variants; $i++) {
            $variant = [];
            foreach ($variants_props as $variant_prop) {
                $variant = array_merge($variant, [$variant_prop => fake()->randomKey($variants_vals[$variant_prop])]);
            }
            $variant = array_merge($variant, ['quantity' => fake()->numberBetween(0, 120)]);
            $variants[] = $variant;
        }

        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'name' => fake()->sentence(),
            'slug' => fake()->slug(),
            'images' => $images,
            'description' => fake()->text(800),
            'price' => $price,
            'price_full' => $price_full,
            'is_active' => fake()->boolean($chanceOfGettingTrue = 90),
            'in_stock' => fake()->boolean($chanceOfGettingTrue = 90),
            'is_featured' => fake()->boolean(),
            'on_sale' => $on_sale,
            'properties' => $properties,
            'variants' => $variants,
            'variant_properties' => $variant_properties,
        ];
    }
}
