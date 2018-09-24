@extends('layouts.app')
@section('page_title', "كل الأقسام | ")
@section('content')
<div class="container">
  <div class="row mt-2">
    <div class="col-lg-9">
      <h3 class="text-right little-title">
        كل التصنيفات
        <small>({{$catCount}} تصنيفًا)</small>
      </h3>
      @if(count($categories))
        <div class="row row-eq-height">
          @foreach($categories as $category)
            <div class="col-xs-6 col-sm-4 col-md-3">
              <div class="article py-5">
                <a href="{{route('category.show', $category->slug)}}" style="font-family: Cairo">{{$category->title}}</a>
              </div>
            </div>
          @endforeach
        </div>
        {{$categories->links()}}
      @else
        <p class="alert alert-info text-right lead" style="background: none">
          لا يوجد تصنيفات
        </p>
      @endif
    </div>
    @include('layouts.sidebar')
  </div><!-- Row -->
</div>
@endsection
