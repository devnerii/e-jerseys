<?php

namespace App\Http\View\Composers;

use App\Models\HomePage;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class HomePageComposer
{
    public function compose(View $view)
    {
        $slug = Route::current()->parameter('homePageSlug');

        $homePage = HomePage::where('slug', $slug)->first() ?? HomePage::first();
        $view->with([
            'homePage' => $homePage,
            'homePageSlug' => $homePage->slug,
        ]);
    }
}
