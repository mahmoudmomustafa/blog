<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use Illuminate\Support\Facades\Auth;

class BlogController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
            $posts = Post::with('category', 'author')->latest()->paginate(8);
        } else {
            // auth();
            Auth::user();
            $posts = Post::where('author_id', Auth::user()->id)->latest()->paginate(8);;
        }
        return view("backend.blog.index", compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post)
    {
        $categories = Category::get();
        return view('backend.blog.create', compact('post', 'categories'));
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
            'slug' => 'required|unique:posts',
            'description' => 'required',
            'category_id' => 'required',
        ]);
        $request->user()->posts()->create($request->all());

        return redirect('/backend/blog')->with('message', 'Ur Post was created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::get();

        if (Auth::user()->isAdmin() || Auth::user()->isEditor()) {
            $post = POST::findOrFail($id);
        } else {
            $post = POST::findOrFail($id);
            $this->authorize('view', $post);
        }
        return view('backend/blog/edit', compact('post', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = POST::findOrFail($id);
        $this->authorize('view', $post);
        return view('backend/blog/index', compact("post"));
    }

    /**
     * Update the specified resource in storage.
     *\
     */
    public function update($id)
    {
        // $post->update(request()->all());
        POST::findOrFail($id)->update(request()->all());
        return redirect('/backend/blog')->with('message', 'Ur Post was Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = POST::findOrFail($id);
        $post->delete();
        return redirect('/backend/blog')->with('message', 'Post was Deleted');
    }
}
