@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if(count($posts) >= 1)
        @foreach($posts as $post)
            <div class="card p-3 mt-3 mb-3">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/posts/{{$post->id}}">{{$post->name}}</a></h3>
                        <h4>+{{$post->upvote}}  -{{$post->downvote}}</h4>
                        <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center">
            {{$posts->links()}}
        </div>
    @else
        <p>No posts found</p>
    @endif
@endsection
