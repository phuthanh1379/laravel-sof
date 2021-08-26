@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-primary">Back</a>
    <h1 style="margin-top:3vh;">{{$post->name}}</h1>
    <br><br>
    <div>
        {!!$post->body!!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>
    @if(count($post->comments) >= 1)
        @foreach($post->comments as $comment)
            <div class="card p-3 mt-3 mb-3">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h4>{!! $comment->content !!}</h4>
                        <small>Written on {{$comment->created_at}} by {{$comment->user->name}}</small>
                    </div>
                </div>
            </div>
        @endforeach
{{--        <div class="d-flex justify-content-center">--}}
{{--            {{$post->comments->links()}}--}}
{{--        </div>--}}
    @else
        <p>No comments for this post yet.</p>
    @endif
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a>

            <div class="pull-right">
                {!!Form::open(['action' => ['App\Http\Controllers\PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                {!!Form::close()!!}
            </div>
        @else
            {!!Form::open(['action' => ['App\Http\Controllers\PostsController@upvote', $post->id], 'method' => 'POST'])!!}
                {{Form::submit('Upvote', ['class' => 'btn btn-primary'])}}
            {!!Form::close()!!}

            {!!Form::open(['action' => ['App\Http\Controllers\PostsController@downvote', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::submit('Downvote', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
        <a href="/posts/comment/{{$post->id}}" class="btn btn-primary">Leave a comment</a>
    @endif
@endsection
