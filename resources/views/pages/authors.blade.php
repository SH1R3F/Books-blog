@extends('layouts.app')
@section('page_title', "كل المؤلفين | ")
@section('content')
<div class="container">
  <div class="row mt-2">
    <div class="col-lg-9">
      <h3 class="text-right little-title">
        كل المؤلفون
        <small>({{$authorsCount}} مؤلفا)</small>
      </h3>
      @if(count($authors))
        <div class="row row-eq-height">
          @foreach($authors as $author)
            <div class="col-xs-6 col-sm-4 col-md-3">
              <div class="article py-5">
                <a href="{{route('author.show', $author->slug)}}" style="font-family: Cairo">{{$author->author_name}}</a>
              </div>
            </div>
          @endforeach
        </div>
        {{$authors->links()}}
      @else
        <p class="alert alert-info text-right lead" style="background: none">
          لا يوجد مؤلفون
        </p>
      @endif
    </div>
    @include('layouts.sidebar')
  </div><!-- Row -->
</div>
@endsection
