<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function filters()
    {
        $perPage = request('perPage', 10);

        $search = request('search') ? explode(' ', request('search')) : [''];

        $filters = request('filters') ? json_decode(request('filters')) : null;

        try {
            if (($filters && is_array($filters)) || (count($search) > 0  && $search[0] !== '')) {
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
