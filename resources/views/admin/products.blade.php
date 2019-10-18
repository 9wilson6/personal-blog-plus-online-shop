@extends('layouts.admin')
@section('title') Admin Products @endsection
@section('content')
    <div class="content">
        <div class="card-header bg-light">
            Admin Products <a class="btn btn-sm btn-info" href="{{route('adminNewProduct')}}">New Product</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Thumbnail</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $post)
                        <tr>
                            <td>{{$post->id}}</td>
                            <td class="text-nowrap"><a href="{{route('adminEditProduct', $post->id )}}"><img src="{{asset($post->thumbnail)}}" width="100px" alt="product image"></a></td>
                            <td>{{$post->title}}</td>
                            <td class="text-nowrap"><a href="{{route('adminEditProduct', $post->id )}}">{{$post->description}}</a></td>
                            <td>{{$post->price}} USD</td>
                            <td>
                                <a href="{{route('adminEditProduct', $post->id)}}" class="btn btn-warning">Edit</a>
                                <form id="postId-{{$post->id}}" action="{{route('adminEditProduct', $post->id)}}" method="POST">@csrf</form>
                                <a data-toggle="modal" data-target="#deleteProduct-{{$post->id}}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @foreach($products as $post)
        <!-- Modal -->
        <div class="modal fade" id="deleteProduct-{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                        <form  id="postId-{{$post->id}}" action="{{route('deleteProduct', $post->id)}}" method="POST">@csrf
                            <button type="submit" class="btn btn-danger">Yes delete it</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @endforeach
@endsection