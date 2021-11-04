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
        $products = array(
            "Azastrole",
            "Bicalox",
            "Calciprox",
            "Frusax",
            "Dermatane",
            "Frusax",
            "Panthron",
            "Proclazine",
            "Rispernia",
            "Lentol",
            "Imazan",
            "Cilopam",
            "Cirofaxin",
            "Cirofaxin",
            "Doxiris",
            "Doxiris",
            "Gemfitril",
        );
        foreach($products as $val) {
            Product::create([
                'name' => $val,
                'available_stock' => mt_rand(1, 9999),
            ]);
        }
    }
}
