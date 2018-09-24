@extends('layouts.app')
@section('page_title', "كل العلامات | ")
@section('content')
<div class="container">
  <div class="row mt-2">
    <div class="col-lg-9">
      <h3 class="text-right little-title">
        كل العلامات
        <small>({{$tagsCount}} علامة)</small>
      </h3>
      @if(count($tags))
        <div class="row row-eq-height">
          @foreach($tags as $tag)
            <div class="col-xs-6 col-sm-4 col-md-3">
              <div class="article py-5">
                <a href="{{route('tag.show', $tag->slug)}}" style="font-family: Cairo">{{$tag->title}}</a>
              </div>
            </div>
          @endforeach
        </div>
        {{$tags->links()}}
      @else
        <p class="alert alert-info text-right lead" style="background: none">
          لا يوجد علامات
        </p>
      @endif
    </div>
    @include('layouts.sidebar')
  </div><!-- Row -->
</div>
@endsection
