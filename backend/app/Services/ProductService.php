<?php

namespace App\Services;

use App\Models\Product;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;


class ProductService
{


    public static function applyFilters($filters, $perPage, $search)
    {
        info('In ApplyFilters');
        info($filters);
        info($perPage);
        info($search);
        // $brandIds = [];
        // $categoryIds = [];
        // $priceRange = [];
        // $warrantys = [];

        // if ($filters && is_array($filters)) {
        //     foreach ($filters as $filter) {
        //         if (isset($filter['name2'])) {
        //             if ($filter['name2'] === 'Garantia') {
        //                 foreach ($filter['values'] as $value) {
        //                     if ($value['selected']) {
        //                         $warrantys[] = [
        //                             'name' => $value['name'],
        //                             'min' => $value['min'],
        //                             'max' => $value['max'],
        //                         ];
        //                     }
        //                 }
        //             } else if ($filter['name2'] === 'Linea') {
        //                 $categoryIds = $filter['values'];
        //             }
        //         } else if ($filter['name'] === 'Marca') {
        //             $brandIds = $filter['values'];
        //         } else if ($filter['name'] === 'Precio') {
        //             $priceRange[] = $filter['values']['min'];
        //             $priceRange[] = $filter['values']['max'];
        //         }
        //     }
        // }


        // // $query = Product::with('image');

        // $query = Product::all();
        // if (count($search) > 0 && $search[0] !== '') {
        //     $query->where(function ($q) use ($search) {
        //         foreach ($search as $param) {
        //             $q->where('name', 'like', '%' . $param . '%')
        //                 ->orWhere('code', 'like', '%' . $param . '%');
        //             // ->orWhere('slug', 'like', '%' . $param . '%');
        //         }
        //     });
        // }

        // if (count($brandIds) > 0) {
        //     $query->whereIn('brand_id', $brandIds);
        // }

        // if (count($categoryIds) > 0) {
        //     $query->whereIn('line_id', $categoryIds);
        // }
        // if (count($priceRange) > 0) {
        //     $query->whereBetween('referential_purchase_price', $priceRange);
        // }
        // return  $query->paginate(intVal($perPage));
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
