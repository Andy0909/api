<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ]);
        }
        try{
            DB::beginTransaction();
            foreach($request['cart'] as $value){
                if(isset($value['order_id'])){
                    $updateQuantity = $this->productService->updateQuantity($value['product_id'],$value['quantity']);
                    if($updateQuantity){
                        $cart = Cart::create([
                            'order_id' => $value['order_id'],
                            'user_id' => $value['user_id'],
                            'product_id' => $value['product_id'],
                            'quantity' => $value['quantity']
                        ]);
                    }
                    else{
                        DB::rollback();
                        return response()->json([
                            'code' => '500',
                            'message' => '商品數量不足'
                        ]);
                    }
                }
            }
            DB::commit();
        }
        catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'code' => '200',
            'message' => '訂單建立成功',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
