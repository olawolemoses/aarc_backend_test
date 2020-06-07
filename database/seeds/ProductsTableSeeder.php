<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'title'=>'Learner', 
                'amount'=>5000, 
                'description' => json_encode(array("300 Users","50GB Storage","300 Public Projects","Community Access","1000 Private Projects","Dedicated Phone Support","Free Subdomains","Monthly Status Reports")),
                'subscription_plan'=>'PLN_ikkedfh1xfbyhcr'
            ],
            [
                'title'=>'Deluxe', 
                'amount'=>10000, 
                'description' => json_encode(array("1000 Users","100GB Storage","100000 Public Projects","Community Access","100000 Private Projects","Dedicated Phone Support","Free Subdomains","Monthly Status Reports")),
                'subscription_plan'=>'PLN_x8z0zdn0vmzqcxy'
            ],
            [
                'title'=>'PRO', 
                'amount'=>20000, 
                'description' => json_encode(array("Unlimited Users","300GB Storage","Unlimited Public Projects","Community Access","Unlimited Private Projects","Dedicated Phone Support","Free Subdomains","Monthly Status Reports")),
                'subscription_plan'=>'PLN_numi9y3x5k7tj4v'
            ],                        
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}