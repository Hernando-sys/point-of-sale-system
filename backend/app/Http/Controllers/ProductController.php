<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return response()->json($products);
    }
    public function getDataForFilters()
    {
        $prices = Product::pluck('price')->toArray();


        $maxPrice = max($prices);
        $maxPrice = round($maxPrice);
        $maxPrice = ceil($maxPrice / 5) * 5;
        $minPrice = 0;

        $range = $maxPrice - $minPrice;

        // Calculate the number of bars based on the range of prices
        $minNumberOfBars = 10;
        $numberOfBars = max($minNumberOfBars, ceil($range / 200));
        $intervalWidth = $range / $numberOfBars;

        $mappedPrices = [];

        // Create intervals and count products within each interval
        for ($i = 0; $i < $numberOfBars; $i++) {
            $lowerBound = $minPrice + $i * $intervalWidth;
            $upperBound = $minPrice + ($i + 1) * $intervalWidth;

            // Count products within the current interval
            $count = collect($prices)->filter(function ($price) use ($lowerBound, $upperBound) {
                return $price >= $lowerBound && $price < $upperBound;
            })->count();

            // Store the count for the current interval
            $mappedPrices[] = [
                'lowerBound' => $lowerBound,
                'upperBound' => $upperBound,
                'count' => $count,
            ];
        }

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();
        $suppliers = Supplier::withCount('products')->get();

        return response()->json(['brands' => $brands, 'categories' => $categories, 'suppliers' => $suppliers, 'maxPrice' => $maxPrice, 'minPrice' => $minPrice, 'mappedPrices' => $mappedPrices, 'intervalWidth' => $intervalWidth]);
    }
    public function filterProducts()
    {
        $perPage = request('perPage', 10);

        $search = request('search') ? explode(' ', request('search')) : [''];

        $filters = request('filters') ? json_decode(request('filters'), true) : null;

        info($filters);
        info('search', $search);
        try {
            if (($filters && is_array($filters)) || $search[0] !== '') {
                $products = ProductService::applyFilters($filters, $perPage, $search);
            } else {
                $products = Product::paginate(intval($perPage));
            }
        } catch (\Exception $ex) {
            \Log::error('Error fetching products: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
        return response()->json($products);
    }
}
