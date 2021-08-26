@extends('layouts.app')

@section('content')
    <h1>Create a comment for post #{{$post->id}} - {{$post->name}}</h1>
    {!! Form::open(['action' => ['App\Http\Controllers\PostsController@createComment', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('content', 'Content')}}
            {{Form::textarea('content', '', ['class' => ['form-control', 'ckeditor'], 'placeholder' => 'Content Text'])}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
