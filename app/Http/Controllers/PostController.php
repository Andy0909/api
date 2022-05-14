<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

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
        $this->validate($request, [
            'title' => 'required|max:100',
            'content' => 'required',
            'name' => 'required|string',
            'email' => 'required|string'
        ]);
        try {
            Post::create([
                'title' => request('title'),
                'content' => request('content'),
                'name' => request('name'),
                'phone' => request('phone'),
                'email' => request('email')
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        return [
            'title' => request('title'),
            'content' => request('content'),
            'name' => request('name'),
            'phone' => request('phone'),
            'email' => request('email')
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
