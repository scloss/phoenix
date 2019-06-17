@include('navigation.p_header')
<div class="alert alert-danger">
  <strong>Note!</strong> {{$msg}}.
</div>
@if($url)
  	<a class="btn btn-primary" href="{{$url}}"><b>Return To Previous Page</b></a>
@endif
@include('navigation.p_footer')