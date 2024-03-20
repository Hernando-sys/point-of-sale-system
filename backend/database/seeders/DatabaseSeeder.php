<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Supplier;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('xd'),
        ]);

        Supplier::create(
            [
                'name' => 'Supplier 1',
                'phone' => '1234567890',
                'email' => 'supplier@example.com',
                'address' => '123 Main St, City, State, 12345'
            ],
        );
        Supplier::create([
            'name' => 'Supplier 2',
            'phone' => '1234567890',
            'email' => 'aa@asd.com'
        ]);
        // Create brands
        Brand::create(['name' => 'Brand 1']);
        Brand::create(['name' => 'Brand 2']);
        Brand::create(['name' => 'Brand 3']);
        Brand::create(['name' => 'Brand 4']);

        // Create categories
        Category::create(['name' => 'Category 1']);
        Category::create(['name' => 'Category 2']);
        Category::create(['name' => 'Category 3']);

        Product::create(
            [
                'name' => 'Product 1',
                'code' => '123456',
                'description' => 'Description 1',
                'price' => 100,
                'cost' => 100,
                'stock' => 10,
                'supplier_id' => 1,
                'brand_id' => 1,
                'category_id' => 1,
            ],
        );

        Product::create(
            [
                'name' => 'Product 2',
                'code' => '123457',
                'description' => 'Description 2',
                'price' => 200,
                'cost' => 200,
                'stock' => 20,
                'supplier_id' => 1,
                'brand_id' => 2,
                'category_id' => 2,
            ],
        );

        Product::create(
            [
                'name' => 'Product 3',
                'code' => '123458',
                'description' => 'Description 3',
                'price' => 300,
                'cost' => 300,
                'stock' => 30,
                'supplier_id' => 1,
                'brand_id' => 3,
                'category_id' => 3,
            ],
        );
        Product::create(
            [
                'name' => 'Product 4',
                'code' => '123459',
                'description' => 'Description 4',
                'price' => 400,
                'cost' => 400,
                'stock' => 40,
                'supplier_id' => 2,
                'brand_id' => 2,
                'category_id' => 2,
            ]
        );

        Product::create(
            [
                'name' => 'Product 5',
                'code' => '123460',
                'description' => 'Description 5',
                'price' => 500,
                'cost' => 500,
                'stock' => 50,
                'supplier_id' => 2,
                'brand_id' => 3,
                'category_id' => 3,
            ]
        );

        Product::create(
            [
                'name' => 'Product 6',
                'code' => '123461',
                'description' => 'Description 6',
                'price' => 600,
                'cost' => 600,
                'stock' => 60,
                'supplier_id' => 2,
                'brand_id' => 4,
                'category_id' => 1,
            ]
        );

        Product::create(
            [
                'name' => 'Product 7',
                'code' => '123462',
                'description' => 'Description 7',
                'price' => 700,
                'cost' => 700,
                'stock' => 70,
                'supplier_id' => 2,
                'brand_id' => 1,
                'category_id' => 2,
            ]
        );

        Product::create(
            [
                'name' => 'Product 8',
                'code' => '123463',
                'description' => 'Description 8',
                'price' => 800,
                'cost' => 800,
                'stock' => 80,
                'supplier_id' => 2,
                'brand_id' => 2,
                'category_id' => 3,
            ]
        );


        Product::create(
            [
                'name' => 'Product 9',
                'code' => '123464',
                'description' => 'Description 9',
                'price' => 900,
                'cost' => 900,
                'stock' => 90,
                'supplier_id' => 2,
                'brand_id' => 3,
                'category_id' => 1,
            ]
        );


        Product::create(
            [
                'name' => 'Product 10',
                'code' => '123465',
                'description' => 'Description 10',
                'price' => 1000,
                'cost' => 1000,
                'stock' => 100,
                'supplier_id' => 2,
                'brand_id' => 4,
                'category_id' => 2,
            ]
        );


        Product::create(
            [
                'name' => 'Product 11',
                'code' => '123466',
                'description' => 'Description 11',
                'price' => 1100,
                'cost' => 1100,
                'stock' => 110,
                'supplier_id' => 2,
                'brand_id' => 1,
                'category_id' => 3,
            ]
        );


        Product::create(
            [
                'name' => 'Product 12',
                'code' => '123467',
                'description' => 'Description 12',
                'price' => 1200,
                'cost' => 1200,
                'stock' => 120,
                'supplier_id' => 2,
                'brand_id' => 2,
                'category_id' => 1,
            ]
        );

        Product::create(
            [
                'name' => 'Product 13',
                'code' => '123468',
                'description' => 'Description 13',
                'price' => 1300,
                'cost' => 1300,
                'stock' => 130,
                'supplier_id' => 2,
                'brand_id' => 3,
                'category_id' => 2,
            ]
        );
    }
}
