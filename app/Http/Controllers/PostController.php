<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'content' => 'required',
            'name' => 'required|string',
            'email' => 'required|string'
        ]);
        if($validator->fails()){
            return [
                'message' => $validator->errors()
            ];
        }
        try {
            Post::create([
                'title' => request('title'),
                'content' => request('content'),
                'name' => request('name'),
                'phone' => request('phone'),
                'email' => request('email')
            ]);
            $details = [
                'title' => '用戶問題回覆',
                'body' => request('name').' 您好，我們已收到您的信件，我們會盡快幫您解決'
            ];
           
            \Mail::to(request('email'))->send(new \App\Mail\Member_Reply_Mail($details));
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return [
            'title' => request('title'),
            'content' => request('content'),
            'name' => request('name'),
            'phone' => request('phone'),
            'email' => request('email'),
            'message' => 'ok'
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
            $post = Post::findOrFail($id);
            $post->update($request->all());
            return $post;
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
        try {
            $post = Post::findOrFail($id);
            return $post->delete();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
