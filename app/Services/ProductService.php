<?php 

namespace App\Services;

use App\Jobs\ProductNotify;
use App\Models\Product;
use App\Models\Subscribe;

class ProductService
{
    public function productNotify($category_id, $productName)
    {
        $userList = Subscribe::where('category_id',$category_id)->with('user')->get();
        foreach($userList as $user){
            \Mail::to($user->user->email)->queue(new \App\Mail\Product_Publish_Mail($user->user->name,$productName));
        }
    }

    public function updateQuantity($product_id,$quantity)
    {
        $totalQuantity = Product::where('id', $product_id)->get();
        $totalQuantity = $totalQuantity[0]->quantity - $quantity;
        if($totalQuantity>0){
            Product::where('id', $product_id)->update(['quantity' => $totalQuantity]);
            return true;
        }
        elseif($totalQuantity<0){
            return false;
        }
        else{
            Product::where('id', $product_id)->update(['quantity' => $totalQuantity]);
            Product::where('id', $product_id)->update(['status' => 0]);
            return true;
        }
    }
}