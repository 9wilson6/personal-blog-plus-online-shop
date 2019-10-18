@extends('layouts.master')
@section('content')
<!-- Page Header -->
<header class="masthead" style="background-image: url('{{asset('assets/img/post-bg.jpg')}}')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="post-heading">
                    <h1>{{$post->title}}</h1>

                    <span class="meta">Posted by
              <a href="#">{{$post->user->name}}</a>
              on {{date_format($post->created_at, 'F d, Y')}}</span>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Post Content -->
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                {!! nl2br($post->content) !!}
            </div>
        </div>
        <div class="comments">
            <hr>
            @foreach($post->comments as $comment);
            <h2>Comment</h2>
            <p>{{$comment->content}} <br>
            <hr>
            <small>by {{$comment->user->name}}</small> on {{date_format($comment->created_at, 'F d, Y')}}</p>
            <hr>
                @endforeach
            @if(Auth::check())
                <form action="{{route('newComment')}}" method="POST">
                    @csrf
                   <div class="form-group">
                       <textarea name="comment" id="" cols="30" rows="5" placeholder="Comment....." class="form-control"></textarea>
                       <input type="hidden" name="post_id" value="{{$post->id}}">
                   </div>
                    <div class="form-group">
                        <input type="submit" value="Make Comment" class="btn btn-info btn-block">
                    </div>
                </form>
            @endif
        </div>
    </div>
</article>

@endsection