<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Testimonial;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class SiteController extends Controller
{

    public function index()
    {
        $sliders = Slider::where('status', 1)
            ->where(function ($query) {
                $query->whereNull('date_start')
                    ->orWhere('date_start', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('date_end')
                    ->orWhere('date_end', '>=', now());
            })
            ->orderBy('id', 'desc')
            ->get();

        $products = Product::active()->get();

        return view('site.pages.home', compact('sliders', 'products'));
    }

    public function pageShow($slug)
    {
        $page = Page::where('slug', $slug)->first();

        return view('examples.pages_show', compact('page'));
    }

    public function serviceShow($slug)
    {
        $service = Service::where('slug', $slug)->first();

        return view('examples.services_show', compact('service'));
    }

    public function portfolioShow($slug)
    {
        $portfolio = Portfolio::where('slug', $slug)->first();

        return view('examples.portfolios_show', compact('portfolio'));
    }

    public function categoriesIndex()
    {
        $categories = Category::active()->ordered()->get();
        $products = Product::active()->get();

        return view('site.pages.categories', compact('categories', 'products'));
    }

    public function productsByCategory($slug)
    {
        $category = Category::where('slug', $slug)->active()->first();
        
        if (!$category) {
            abort(404);
        }

        $products = Product::active()->where('category_id', $category->id)->with('category')->get();
        $categories = Category::active()->ordered()->get();

        return view('site.pages.products_by_category', compact('products', 'category', 'categories'));
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)->active()->first();

        if (!$product) {
            abort(404);
        }

        return view('site.pages.product_detail', compact('product'));
    }

    public function about()
    {
        return view('site.pages.about');
    }

    public function services()
    {
        return view('site.pages.services');
    }

    public function sustainability()
    {
        return view('site.pages.sustainability');
    }
}
