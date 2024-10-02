<?php 

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\HomePage;
use Illuminate\Support\Facades\Route;

class HomePageComposer
{
    public function compose(View $view)
    {
        $slug = Route::current()->parameter('slug');
        $parameters = Route::current()->parameters();
       // dd($slug);
        $homePage = HomePage::where('slug', $slug)->first() ?? HomePage::first();


        $view->with([
            'homePage' => $homePage,
            'slug' => $homePage->slug,
        ]);
    }
}
