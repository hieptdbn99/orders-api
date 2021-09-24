<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $product = [
            [
                'name' => 'Book',
                'price' => '20000',
            ],
            [
                'name' => 'Vở',
                'price' => '5000',
            ],
            [
                'name' => 'Bút',
                'price' => '2000',
            ],
            [
                'name' => 'Xe đạp',
                'price' => '2000000',
            ],
            [
                'name' => 'Xe máy',
                'price' => '20000000',
            ]
        ];
        foreach ($product as $item){
            Product::create($item);
        }
    }
}
