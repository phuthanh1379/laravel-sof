@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        {{-- @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }} --}}

                        <div class="panel-body">
                            <a href="posts/create" class="btn btn-primary">Create your post</a>
                            <h3>Your posts</h3>
                            @if(count($posts) > 0)
                                <table class="table table-striped">
                                    <tr>
                                        <th>Title</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    @foreach($posts as $post)
                                        <tr>
                                            <td>{{$post->name}}
                                            <td>+{{$post->upvote}}</td>
                                            <td>-{{$post->downvote}}</td>

                                            <td><a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a></td>
                                            <td>
                                                <div class="pull-right">
                                                    {!!Form::open(['action' => ['App\Http\Controllers\PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                                        {{Form::hidden('_method', 'DELETE')}}
                                                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                                    {!!Form::close()!!}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                <p>Uh-oh you currently have no posts. Create one!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
