<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Post;
use App\Category;
use App\Tag;
use Image;
use Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        $category_array = [];

        foreach ($categories as $category) {
            $category_array[$category->id] = $category->name;
        }

        $tags = Tag::all();

        $tag_array = [];

        foreach ($tags as $tag) {
            $tag_array[$tag->id] = $tag->name;
        }

        return view('posts.create')->with('categories', $category_array)->with('tags', $tag_array);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostFormRequest $request)
    {
        $post = new Post;

        $post->author      = $request->author;
        $post->title       = $request->title;
        $post->slug        = $request->slug;
        $post->body        = $request->body;
        $post->category_id = $request->category;
 
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/uploads/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);

            $post->image = $filename;
        }

        $post->save();

        if (isset($request->tags)) {
            $post->tags()->sync($request->tags, false);
        } else {
            $post->tags()->sync(array());
        }

        flash()->overlay('Thanks!', 'Your New Blog Post Was Created Successfully');

        return redirect()->route('posts.show', $post->id);
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

        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts = Post::find($id);

        $categories = Category::all();

        $category_array = [];

        foreach ($categories as $category) {
            $category_array [$category->id] = $category->name;
        }

        $tags = Tag::all();

        $tag_array = [];

        foreach ($tags as $tag) {
            $tag_array[$tag->id] = $tag->name;
        }

        return view('posts.edit')->with('post', $posts)->with('categories', $category_array)->with('tags', $tag_array);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request, $id)
    {
        $post = Post::find($id);

        $post->author      = $request->author;
        $post->title       = $request->title;
        $post->slug        = $request->slug;
        $post->body        = $request->body;
        $post->category_id = $request->category_id;

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/uploads/' . $filename);
            Image::make($image)->resize(800, 400)->save($location);

            $oldFileName = $post->image;

            $post->image = $filename;

            Storage::delete($oldFileName);
        }

        $post->save();

        if (isset($request->tags)) {
            $post->tags()->sync($request->tags, true);
        } else {
            $post->tags()->sync(array());
        }

        flash()->overlay('Thanks!', 'Your Blog Post Was Updated Successfully');

        return redirect()->route('posts.show', $post->id);
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
        $post->tags()->detach();
        Storage::delete($post->image);

        $post->delete();

        flash()->success('Thanks!', 'Your Blog Post Was Deleted Successfully');

        return redirect()->route('posts.index');
    }
}