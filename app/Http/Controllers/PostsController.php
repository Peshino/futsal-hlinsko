<?php

namespace App\Http\Controllers;

use App\Post;
use App\Repositories\Posts;

class PostsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth')->except(['index', 'show']);
  }

  public function index(Posts $posts)
  {
    // $posts = Post::latest()
    //   ->filter(request(['month', 'year']))
    //   ->get();
    $posts = $posts->all();

    return view('posts.index', compact('posts'));
  }

  public function show(Post $post)
  {
    return view('posts.show', compact('post'));
  }

  public function create()
  {
    return view('posts.create');
  }

  public function store()
  {
    $this->validate(request(), [
      'title' => 'required|max:100',
      'body' => 'required|max:200',
    ]);

    auth()->user()->publish(new Post(request(['title', 'body'])));

    session()->flash('message', 'Článek byl vytvořen.');

    return redirect('posts');
  }
}
