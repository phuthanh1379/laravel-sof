<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Comment;
use DB;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(2);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create new post
        $post = new Post;
        $post->name = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        // Default values
        $post->upvote = 0;
        $post->downvote = 0;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
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
        $post = Post::find($id);

        // If current user is not matched, throw an error
        if (auth()->user()->id !== $post->user_id) {
            return redirect('posts')->with('error', 'Unauthorized Page');
        }
        // ... otherwise, return the edit view
        return view('posts.edit')->with('post', $post);
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
        $this -> validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        // Update post
        $post = Post::find($id);
        $post->name = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
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

        // If current user is not matched, throw an error
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }
        // ... otherwise, delete post
        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted');
    }

    /**
     * Upvote a post
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upvote($id)
    {
        $post = Post::find($id);
        $post->upvote += 1;
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Downvote a post
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downvote($id)
    {
        $post = Post::find($id);
        $post->downvote += 1;
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Add a comment to a post
     */
    public function comment($id)
    {
        $post = Post::find($id);
        return view('posts.comment')->with('post', $post);
    }

    /**
     * Create a new comment
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createComment(Request $request, $id)
    {
        $this -> validate($request, [
            'content' => 'required'
        ]);

        // Add comment
        $comment = new Comment;
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $id;
        $comment->content = $request->input('content');
        $comment->save();

        // Redirect back to the post's show page
        $post = Post::find($comment->post_id);
        return redirect()->route('posts.show', ['post' => $post])->with('success', 'Successfully added comment.');
    }
}
