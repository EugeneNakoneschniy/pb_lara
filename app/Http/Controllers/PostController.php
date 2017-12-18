<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts, 200);
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'tags' => 'required'
        ]);
        $data = $request->toArray();
        $data['user_id'] = JWTAuth::parseToken()->authenticate()->id;
        $post = Post::create($data);

        foreach ($request->input('tags') as $tag){
            Tag::firstOrCreate(['name' => $tag])->posts()->attach($post->id);
        }
        return response()->json($post, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if($post){
            return response()->json($post, 200);
        }
        return response()->json([
            'error' => 'Post not found!'
        ], 404);
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'tags' => 'required'
        ]);
        $post = Post::find($id);
        if($post){
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->tags()->detach();
            foreach ($request->input('tags') as $tag){
                Tag::firstOrCreate(['name' => $tag])->posts()->attach($id);
            }
            $post->save();
            return response()->json($post, 200);
        }
        return response()->json([
            'error' => 'Post not found!'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post){
            $post->delete();
            return response()->json([
                'message' => 'Post deleted!'
            ], 200);
        }
        return response()->json([
            'error' => 'Post not found!'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyForce($id)
    {
        $post = Post::withTrashed()
            ->where('id', $id)->first();
        if($post){
            $post->forceDelete();
            return response()->json([
                'message' => 'Post force deleted!'
            ], 200);
        }
        return response()->json([
            'error' => 'Post not found!'
        ], 404);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $post = Post::onlyTrashed()
            ->where('id', $id)->first();
        if($post){
            $post->restore();
            return response()->json([
                'message' => 'Post restored!',
                'post' => $post
            ], 200);
        }
        return response()->json([
            'error' => 'Post not found!'
        ], 404);
    }
}
