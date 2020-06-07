<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Transaction;
use Illuminate\Support\Facades\Validator;
use Yabacon\Paystack;
use DB;

class TransactionController extends Controller
{
    public function initialize(Request $request)
    {
        $input = $request->only('productId');
        $user = $request->user();
        $productId = $input['productId'];
        
        $product = Product::find($productId);

        $amount = $product->amount;

        $reference = $this->getReference();

        $callbackUrl = env('CALLBACK_URL');

        $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'));

        try
        {
            $responseObj = $paystack->transaction->initialize([
                "reference"=> $reference,
                "email"=> $user->email,
                "plan"=> $product->subscription_plan,
                "callback_url"=> $callbackUrl .'/product/' . $product->id
            ]);

        } catch(\Yabacon\Paystack\Exception\ApiException $e){

            print_r($e->getResponseObject());
            die($e->getMessage());
        }


        $transaction = Transaction::create([
            "product_id"=> $product->id,
            "user_id"=> $user->id,
            "email"=> $user->email,
            "status"=> 0,
            "amount"=> $amount,
            "reference"=> $responseObj->data->reference
        ]);

        return response() ->json($responseObj);        
    }

    public function verify(Request $request)
    {
        $input = $request->only('reference', 'productId');

        $user = $request->user();
        
        $productId = $input['productId'];

        $reference = $input['reference'];
        
        $product = Product::find($productId);

        $paystack = new Paystack(env('PAYSTACK_SECRET_KEY'));

        try
        {
            // verify using the library
            $tranx = $paystack->transaction->verify([
                'reference'=>$reference, // unique to transactions
            ]);
            
        } catch(\Yabacon\Paystack\Exception\ApiException $e){
            print_r($e->getResponseObject());
            die($e->getMessage());
        }
    
        if ('success' === $tranx->data->status) {
            // transaction was successful...
            $transaction = Transaction::where('reference', $reference)->first();

            // please check other things like whether you already gave value for this ref

            // if the email matches the customer who owns the product etc

            // Give value
            // put the user_id in the subscribers list
            $transaction->status = 1;

            $transaction->save();
        }

        return response() ->json($tranx->data);
    }    

    public function users(Request $request)
    {
        $user = $request->user();
        
        $transactions = DB::table('transactions')
            ->join('products', 'products.id', '=', 'transactions.product_id')
            ->select('transactions.*', 'products.title') 
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->get();

        return response() ->json([
            'success' => true,
            'transactions' => $transactions
        ], 201);  
    }    

    public function getReference(){
        $text = "";
        $possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for($i = 0; $i < 25; $i++) {
            $text .= substr($possible, round(rand() * strlen($possible)), 1);
        }

        return $text;
      }
}