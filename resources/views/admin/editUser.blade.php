@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            Account Settings
                        </div>
                        @if(session('error'))
                            <div class="alert alert-danger">{{session('error')}}</div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
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
                        <form action="{{route('userAccountEdit', $user->id)}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row mb-5">
                                    <div class="col-md-4 mb-4">
                                        <div>Profile Information</div>
                                        <div class="text-muted small">These information are visible to the public.</div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Name</label>
                                                    <input name="name" class="form-control" value="{{ $user->name }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-control-label">Email Address</label>
                                                    <input name="email" class="form-control" value="{{$user->email}}">
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>
                               <div class="row">
                                   <div class="col-md-4">Set user permisions  </div>


                                           <div class="col-md-4">
                                               <div class="form-group">
                                              <input type="checkbox" class="form-check-input" id="admin" name="admin" value=1 {{$user->admin==true ? 'checked':''}}>
                                              <label for="admin" class="form-check-label">Admin</label>
                                          </div>
                                          </div>

                                           <div class="col-md-4">
                                               <div class="form-group">
                                              <input type="checkbox" class="form-check-input" id="author" name="author" value=1 {{$user->author==true ? 'checked':''}}>
                                              <label for="author" class="form-check-label">Author</label>
                                          </div>
                               </div>


                               </div>

                            <div class="card-footer bg-light text-right">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection