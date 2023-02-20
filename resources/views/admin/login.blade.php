<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="{{csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Timothy Joshua">
    <title>Login | {{config('app.name')}}</title>
    <link rel="icon" href="" sizes="16x16" type="image/png">
    <link rel="canonical" href="{{url()->current()}}">   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<style type="text/css">
  img{cursor:pointer;}
</style>
<body>
  <div class="py-5 bg-light">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-5 col-sm-8 col-xs-12">
          <div class="card shadow-sm">  
            <div class="card-body">
          <h4 class="card-title text-center">Admin Login</h4>
@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show py-1" role="alert">
 <i class="fa fa-times-circle"></i> {!! session('error') !!}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="margin-top:-10px"></button>
</div>
@endif
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show py-1" role="alert">
  <i class="fa fa-check-circle"></i> {!! session('success') !!}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="margin-top:-10px"></button>
</div>
<script>
  setTimeout(()=>{location ="{{route('adhome')}}"},4500);
</script>
@endif
              <form action="{{route('adminLogin')}}" method="post" class="mt-3">
                @csrf
                <div class="form-group mb-3">
                  <label>Email Address</label>
                  <input type="email" name="emailAddress" class="form-control" placeholder="Enter Email Address" value="{{old('emailAddress')}}">
                </div>
                <div class="form-group mb-3">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Enter Password">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Login</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>