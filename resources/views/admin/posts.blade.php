@extends('layouts.admin')
@section('title')Admin Posts @endsection
@section('content')
    <div class="content">
        <div class="card-header bg-light">
            Admin Posts
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Comments</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{$post->id}}</td>
                            <td class="text-nowrap"><a href="{{route('singlePost', $post->id )}}">{{$post->title}}</a></td>
                            <td>{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</td>
                            <td>{{\Carbon\Carbon::parse($post->updated_at)->diffForHumans()}}</td>
                            <td>{{$post->comments->count()}}</td>
                            <td>
                                <a href="{{route('adminPostEdit', $post->id)}}" class="btn btn-warning">Edit</a>
                                <form id="postId-{{$post->id}}" action="{{route('adminDeletePost', $post->id)}}" method="POST">@csrf</form>
                                <a data-toggle="modal" data-target="#deletePost-{{$post->id}}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @foreach($posts as $post)
        <!-- Modal -->
        <div class="modal fade" id="deletePost-{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
                        <h4 class="modal-title" id="myModalLabel">You are About {{$post->title}}.</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">No keep it</button>
                        <form  id="postId-{{$post->id}}" action="{{route('adminDeletePost', $post->id)}}" method="POST">@csrf
                        <button type="submit" class="btn btn-danger">Yes delete it</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endforeach
@endsection