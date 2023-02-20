@php
$items=array();
  if($plv){
      foreach($plv as $val){
        $items[]= $val->role;
      }
  }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="{{csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Timothy Joshua">
    <title>Newsfeed | {{config('app.name')}}</title>
    <link rel="icon" href="" sizes="16x16" type="image/png">
    <link rel="canonical" href="{{url()->current()}}">   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<style type="text/css">
  img{cursor:pointer;}
</style>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="{{route('adhome')}}">New Parser</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse float-end" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
        <li class="nav-item"><a class="nav-link" href="{{route('adhome')}}">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('newsfeed')}}">News Update</a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('adlogout')}}">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>  


<main class="mt-5">

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

@if($datas)
  @foreach($datas as $key => $data)
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="card shadow-sm">           
            <img src="{{$data->image}}" title="{{$data->title}}" alt="{{$data->title}}" class="img img-responsive">
            <div class="card-body">
              <p class="card-text">{!!substr($data->short_description,0,150)!!}</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="" type="button" class="btn btn-sm btn-outline-secondary text-primary">View</a>
            @php if($plv){ if(in_array('actions',$items)){ @endphp
                @if($data->status=='active')
                  <a href="{{route('newsStatus',['inactive',$data->token])}}" type="button" class="btn btn-sm btn-outline-secondary text-warning">Suspend</a>
                @elseif($data->status=='inactive')
                  <a href="{{route('newsStatus',['active',$data->token])}}" type="button" class="btn btn-sm btn-outline-secondary text-success">Activate</a>
                @endif
            @php }} if($plv){ if(in_array('moderator',$items)){ @endphp
                <a href="#" type="button" class="btn btn-sm btn-outline-secondary text-info">Modify</a>
            @php }} if($plv){ if(in_array('delete',$items)){ @endphp
                  <a href="{{route('newsStatus',['delete',$data->token])}}" type="button" class="btn btn-sm btn-outline-secondary text-danger">Delete</a>
            @php }} @endphp
                </div>
                <small class="text-muted">9 mins</small>
              </div>
            </div>
          </div>
        </div>  
  @endforeach
@endif
      </div>

<div class="col-lg-12">
  {{$datas->links('vendor.pagination.custom')}}
</div>

    </div>
  </div>

</main>

<footer class="text-muted py-2 mt-3">
  <div class="container">    
    <p class="text-center">New Parser &copy - {{date('Y')}}</p>
  </div>
</footer>     
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>  
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>