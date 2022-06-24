<?php 

namespace App\Services;

use App\Jobs\ProductNotify;
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
}