@extends('layouts.admin')
@section('title') Edit product @endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            Edit Product
                        </div>
                        @if(Session::has('success'))
                            <div class="alert alert-success">{{Session::get('success')}}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('updateProduct', $product->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="normal-input" class="form-control-label">Thumbnail</label>
                                            <input type="file"  id="normal-input" name="thumbnail" class="form-control-file">
                                        </div>
                                        <img src="{{asset($product->thumbnail)}}" width="100px" alt="">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="normal-input" class="form-control-label">Product Title</label>
                                            <input id="normal-input" name="title" value="{{$product->title}}" class="form-control" placeholder="Product Title">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">


                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="required-input">Product description</label>
                                            <textarea class="form-control" name="description" id="" cols="30" rows="5" placeholder="Product Content">{{$product->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="price" class="form-control-label">Product Price</label>
                                            <input type="number" id="price" name="price" value="{{$product->price}}" class="form-control" placeholder="10.00">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection