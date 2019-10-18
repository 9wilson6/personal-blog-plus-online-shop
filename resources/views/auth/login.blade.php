 @extends('layouts.auth')
 @section('title') Login @endsection
 @section('content')
     <div class="container">
         <div class="row justify-content-center">
             <div class="col-md-5">
                 <div class="card p-4">
                     <div class="card-header text-center text-uppercase h4 font-weight-light">
                         Login
                     </div>

                     <div class="card-body py-5">
                         <form method="POST" action="{{ route('login') }}">
                             @csrf
                             <div class="form-group">
                                 <label class="form-control-label">Email</label>
                                 <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                 @error('email')
                                 <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                             </div>

                             <div class="form-group">
                                 <label class="form-control-label">Password</label>
                                 <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                 @error('password')
                                 <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                             </div>

                             <div class="custom-control custom-checkbox mt-4">
                                 <input type="checkbox" name="remember" class="custom-control-input" {{ old('remember') ? 'checked' : '' }} id="login">
                                 <label class="custom-control-label" for="login">Remember Me</label>
                             </div>

                     </div>

                     <div class="card-footer">
                         <div class="row">
                             <div class="col-6">
                                 <button type="submit" class="btn btn-primary px-5">Login</button>
                             </div>
                             </form>
                             <div class="col-6">
                                 <a href="{{ route('password.request') }}" class="btn btn-link">Forgot Your Password?</a>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection