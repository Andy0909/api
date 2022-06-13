<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Product::where('status','1')->get());
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
            'category_id' => 'required',
            'name' => 'required|max:100|unique:products,name',
            'price' => 'required',
            'quantity' => 'required',
            'status' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ]);
        }
        try{
            Product::create([
                'category_id' => request('category_id'),
                'name' => request('name'),
                'content' => request('content'),
                'price' => request('price'),
                'img' => request('img'),
                'quantity' => request('quantity'),
                'status' => request('status')
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'message' => '新建成功',
            'name' => request('name')
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
        try {
            $product = Product::findOrFail($id);
            $product->update($request->all());
            return $product;
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
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
