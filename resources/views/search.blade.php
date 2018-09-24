@extends('layouts.app')
@section('page_title', 'نتائج البحث | ')
@section('content')
<div class="container">
    <div class="row mt-2">
      <div class="col-lg-9">
        <h3 class="text-right little-title col-md-6 float-right">
          نتائج البحث عن {{$query}}
        </h3>
        <div class="clearfix"></div>
        @if(count($books))
          <div class="row row-eq-height">
            @foreach($books as $book)
              <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="article">
                  <a href="{{route('book.show', $book->slug)}}"><img src="{{asset('storage/' . $book->thumbnail)}}" alt="{{$book->book_name}}"></a>
                  <a href="{{route('book.show', $book->slug)}}">{{$book->book_name}}</a>
                </div>
              </div>
            @endforeach
          </div>
          {{$books->links()}}
        @else
          <p class="alert alert-info text-right lead" style="background: none">
            لا يوجد كتب تحمل هذا الاسم
          </p>
        @endif
      </div>
      @include('layouts.sidebar')
    </div><!-- Row -->
</div>
@endsection
