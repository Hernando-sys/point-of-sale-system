<?php

namespace App\Services;

use App\Models\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;


class ProductService
{


    public static function applyFilters($filters, $perPage, $search)
    {
        $brandIds = [];
        $categoryIds = [];
        $supplierIds = [];
        $priceRange = [];

        if ($filters && is_array($filters)) {
            foreach ($filters as $filter) {
                if ($filter['name'] === 'Brand') {
                    $brandIds = $filter['values'];
                } else if ($filter['name'] === 'Category') {
                    $categoryIds = $filter['values'];
                } else if ($filter['name'] === 'Supplier') {
                    $supplierIds = $filter['values'];
                } else if ($filter['name'] === 'Price') {
                    $priceRange[] = $filter['values']['min'];
                    $priceRange[] = $filter['values']['max'];
                }
            }
        }


        // // $query = Product::with('image');

        info($brandIds);
        info('HELOO');
        $query = Product::query();
        if ($search[0] !== '') {
            $query->where(function ($q) use ($search) {
                foreach ($search as $param) {
                    $q->where('name', 'like', '%' . $param . '%')
                        ->orWhere('code', 'like', '%' . $param . '%');
                    // ->orWhere('slug', 'like', '%' . $param . '%');
                }
            });
        }

        if (count($brandIds) > 0) {
            $query->whereIn('brand_id', $brandIds);
        }

        if (count($categoryIds) > 0) {
            $query->whereIn('category_id', $categoryIds);
        }
        if (count($supplierIds) > 0) {
            $query->whereIn('supplier_id', $supplierIds);
        }
        if (count($priceRange) > 0) {
            $query->whereBetween('price', $priceRange);
        }
        return  $query->paginate(intVal($perPage));
    }

    public static function updateImage(Product $product, $request)
    {
        return DB::transaction(function () use ($product, $request) {

            ProductService::deleteImage($product);

            if ($request->imageHasChanged) {
                ProductService::createImage($request->image, $product);
            }

            return $product;
        });
    }

    protected static function deleteImage(Product $product)
    {
        if ($product->image) {
            $oldImagePath = public_path('storage') . '/' . $product->image->url;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $product->image()->delete();
        }
    }

    public static function createImage($image, Product $product)
    {
        $imageName = str_replace(' ', '-', $product->name);
        $savePath = public_path('storage/products');

        if (!file_exists($savePath)) {
            mkdir($savePath, 755, true);
        }

        // Image::make($image)->save("$savePath/$imageName.png");

        $product->image()->create([
            'url' => "products/$imageName.png?v=" . uniqid(),
        ]);
    }
}
