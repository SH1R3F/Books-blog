@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(Session::has('success'))
              <div class="alert alert-success text-right">{{Session::get('success')}}</div>
            @elseif(Session::has('error'))
              <div class="alert alert-danger text-right">{{Session::get('error')}}</div>
            @endif
            @if(Session::has('success_auth'))
              <div class="alert alert-success text-right">{{Session::get('success_auth')}}</div>
            @endif
        </div>
    </div>

    <div class="row mt-2">
      <div class="col-lg-9">
        <h3 class="text-right little-title col-md-6 float-right">
          أحدث الكتب
          <small>({{$bookCount}} كتابًا)</small>
        </h3>
        <form action="{{route('search')}}" method="GET">
          <div class="form-group col-md-6 float-left">
            <input type="text" class="form-control" placeholder="إبحث عن كتاب (إضغط انتر للبحث)" name="query">
          </div>
        </form>
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
            لا يوجد كتب
          </p>
        @endif
      </div>
      @include('layouts.sidebar')
    </div><!-- Row -->
</div>
@endsection
