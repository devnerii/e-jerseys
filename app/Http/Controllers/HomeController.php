<?php

/*namespace App\Http\Controllers;

use App\Models\Product;



class HomeController extends Controller
{
    public function index()
    {
        $produtos_destaques = Product::where('is_active', true)->where('is_featured', true)->inRandomOrder()->limit(6)->get();
        $produtos_principais = Product::where('is_active', true)->where('is_featured', false)->where('show_on_main_page', true)->inRandomOrder()->limit(8)->get();

        return view('home', [
            'produtos_destaques' => $produtos_destaques,
            'produtos_principais' => $produtos_principais,

        ]);
    }
} */

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\HomePage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($slug = null)
    {
        if ($slug) {
            $homePage = HomePage::where('slug', $slug)->firstOrFail();
        } else {
            $homePage = HomePage::firstOrFail(); 
            $slug = $homePage->slug;
        }

        $produtos_destaques = $homePage->products()
            ->where('is_active', true)
            ->where('is_featured', true)
            ->inRandomOrder()
            ->limit(6)
            ->get();


        $produtos_principais = $homePage->products()
            ->where('is_active', true)
            ->where('is_featured', false)
            ->where('show_on_main_page', true)
            ->inRandomOrder()
            ->limit(8)
            ->get();

        $banners = $homePage->banners()->get();


        return view('home', [
            'homePage' => $homePage,
            'produtos_destaques' => $produtos_destaques,
            'produtos_principais' => $produtos_principais,
            'banners' => $banners,
            'slug' => $slug,
        ]);
    }
}
