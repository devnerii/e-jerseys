<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Category;

class CategoryProductSeeder extends Seeder
{
    public function run()
    {
        // Limpar a tabela antes de popular
        DB::table('category_product')->truncate();

        // Obter todos os produtos
        $products = Product::all();

        foreach ($products as $product) {
            // Obter a categoria do produto
            $categoryId = $product->category_id;

            // Se houver uma categoria associada ao produto
            if ($categoryId) {
                // Verificar se a categoria existe antes de associar
                if (Category::find($categoryId)) {
                    DB::table('category_product')->insert([
                        'product_id' => $product->id,
                        'category_id' => $categoryId,
                    ]);
                } else {
                    Log::warning("Categoria com ID {$categoryId} não encontrada para o produto {$product->id}");
                }
            }
        }
    }
}
