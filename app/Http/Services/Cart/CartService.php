<?php

namespace App\Http\Services\Cart;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session ;

class CartService{

    public function addCart($request){
        $qty = (int)$request->input('num-product');
        $product_id = (int)$request->input('product-id');

        if($qty <= 0 || $product_id <= 0){
            Session::flash('error','Quantity must more than 0');
            return false;
        }

        $carts = Session::get('carts');
        
        if(is_null($carts)){

            Session::put('carts',[
                $product_id => $qty
            ]);
            return true;
        }

        // $exists = Arr::exists($carts, $product_id);
        // if ($exists) {
        //     $qtyNew = $carts[$product_id] + $qty;
        //     Session::put('carts',[
        //         $product_id => $qtyNew
        //     ]);
        //     dd($carts); 
        //     return true;
        // }
        // Session::put('carts',[
        //     $product_id => $qty
        // ]);
        // return true;

        $exists = Arr::exists($carts, $product_id);
        if ($exists) {
            $carts[$product_id] = $carts[$product_id] + $qty;
            Session::put('carts', $carts);
            return true;
        }

        $carts[$product_id] = $qty;
        Session::put('carts', $carts);

        return true;

    }

    public function getProduct(){
        $carts = Session::get('carts');
        if(is_null($carts)) return [];
        $productId = array_keys($carts);

        return Product::select('id','name','price','price_sale','thumb')
        ->whereIn('id',$productId)
        ->get();
    }
}