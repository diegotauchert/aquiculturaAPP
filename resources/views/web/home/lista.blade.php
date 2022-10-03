@extends('layouts.web.app')

@section('title', '')
@section('content')
@include('web.home.popups')
<div class="container-fluid mb-4">
  <div class="flex md:block gap-4">
  @include('web.home.menu')
  @include('web.home.banners')
  </div>
</div> 
@include('web.home.blogs')
@include('web.home.agenda')
@include('web.home.cobertura')
@include('web.home.colunista')
@include('web.home.promocoes')
<!-- @include('web.home.newsletter') -->
@endsection
