@extends('layouts.admin')
@section('title') User Comments @endsection
@section('content')
  <div class="content">
      <div class="card-header bg-light">
          User Comments
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-striped">
                  <thead>
                  <tr>
                      <th>ID</th>
                      <th>Post</th>
                      <th>Content</th>
                      <th>Created At</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach(Auth::user()->comments as $comment)
                      <tr>
                          <td>{{$comment->id}}</td>
                          <td class="text-nowrap"><a href="{{route('singlePost', $comment->id )}}">{{$comment->post->title}}</a></td>
                          <td>{{$comment->content}}</td>
                          <td>{{\Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</td>
                          {{--<form id="deleteComment-{{$comment->id}}" action="{{route('deleteComment', $comment->id)}}" method="POST">@csrf</form>--}}
                          <td><a class="btn btn-danger" data-toggle="modal" data-target="#deleteComment-{{$comment->id}}">X</a></td>
                      </tr>
                  @endforeach

                  </tbody>
              </table>
          </div>
      </div>
  </div>
  @foreach(Auth::user()->comments as $comment)
      <!-- Modal -->
      <div class="modal fade" id="deleteComment-{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
                       <h4 class="modal-title" id="myModalLabel">You are About comment for post {{$comment->post->title}}.</h4>
                  </div>
                  <div class="modal-body">
                      Are you sure ?
                  </div>
                  <div class="modal-footer">

                      <button type="button" class="btn btn-default" data-dismiss="modal">No keep it</button>
                      <form  id="postId-{{$comment->id}}" action="{{route('deleteComment', $comment->id)}}" method="POST">@csrf
                          <button type="submit" class="btn btn-danger">Yes delete it</button>
                      </form>
                  </div>
              </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
  @endforeach
@endsection