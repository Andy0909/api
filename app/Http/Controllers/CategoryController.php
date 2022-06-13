<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Category::where('status','1')->get());
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
            'name' => 'required|max:100|unique:categories,name',
            'status' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ]);
        }
        try{
            Category::create([
                'name' => request('name'),
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
        try{
            $category = Category::findOrFail($id);
            $category->update($request->all());
        }
        catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
        return response()->json([
            'message' => '更新成功',
            'category' => $category
        ]);    
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
