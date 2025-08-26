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
use App\Models\Statistic;
use App\Models\PhilosophyPoint;
use App\Models\ServiceFeature;
use App\Models\Faq;
use App\Services\PortfolioService;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    protected $portfolioService;

    public function __construct(PortfolioService $portfolioService)
    {
        $this->portfolioService = $portfolioService;
    }

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
        $statistics = Statistic::where('status', true)->orderBy('sort_order')->get();
        $philosophyPoints = PhilosophyPoint::where('status', true)->orderBy('sort_order')->get();
        $serviceFeatures = ServiceFeature::where('status', true)->orderBy('sort_order')->get();
        $faqs = Faq::where('status', true)->orderBy('sort_order')->get();
        
        // Buscar portfólios organizados por categoria
        $portfoliosByCategory = $this->portfolioService->getPortfoliosByCategory();
        
        // Buscar configurações do site
        $settings = \App\Models\Setting::first();

        return view('site.pages.home', compact('sliders', 'products', 'statistics', 'philosophyPoints', 'serviceFeatures', 'faqs', 'settings', 'portfoliosByCategory'));
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
        $portfolio = Portfolio::with(['category', 'images' => function($query) {
            $query->orderBy('sort_order', 'asc');
        }])->where('slug', $slug)->active()->first();

        if (!$portfolio) {
            abort(404);
        }

        return view('examples.portfolios_show', compact('portfolio'));
    }

    public function categoriesIndex(Request $request)
    {
        $categorySlug = $request->query('category');
        $categories = Category::active()->ordered()->get();
        $selectedCategory = null;
        
        if ($categorySlug) {
            $selectedCategory = Category::where('slug', $categorySlug)->active()->first();
            if ($selectedCategory) {
                $portfoliosByCategory = $this->portfolioService->getPortfoliosByCategory($selectedCategory->id);
            } else {
                $portfoliosByCategory = $this->portfolioService->getPortfoliosByCategory();
            }
        } else {
            $portfoliosByCategory = $this->portfolioService->getPortfoliosByCategory();
        }

        return view('site.pages.categories', compact('categories', 'portfoliosByCategory', 'selectedCategory'));
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
        $philosophyPoints = PhilosophyPoint::where('status', true)->orderBy('sort_order')->get();
        return view('site.pages.about', compact('philosophyPoints'));
    }

    public function services()
    {
        $serviceFeatures = ServiceFeature::where('status', true)->orderBy('sort_order')->get();
        return view('site.pages.services', compact('serviceFeatures'));
    }

    public function contact()
    {
        $faqs = Faq::where('status', true)->orderBy('sort_order')->get();
        return view('site.pages.contact', compact('faqs'));
    }
}
