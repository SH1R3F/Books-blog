@extends('layouts.admin')
@section('page_title', 'لوحة التحكم | ')
@section('content')
  <div class="statistics">
    <div class="container">
      <div class="row">

        <!-- Total visits -->
        <div class="col-xs-6 col-md-2 total-visits">
          <i class="fa fa-refresh"></i>
          <span>عدد الزوار الكلي</span>
          <h1>{{\Visitor::count()}}</h1>
        </div><!-- Total visits -->

        <!-- Total visits -->
        <div class="col-xs-6 col-md-2 total-visits">
          <i class="fa fa-refresh"></i>
          <span>عدد الزيارات الكلية</span>
          <h1>{{\Visitor::clicks()}}</h1>
        </div><!-- Total visits -->

        <!-- Today visits -->
        <div class="col-xs-6 col-md-2 today-visits">
          <i class="fa fa-refresh"></i>
          <span>زوار اليوم</span>
          <h1>{{\Visitor::range(\Carbon\Carbon::today(), \Carbon\Carbon::now())}}</h1>
        </div><!-- Today visits -->

        <!-- Total Users -->
        <div class="col-xs-6 col-md-2 total-users">
          <i class="fa fa-users"></i>
          <span>عدد المستخدمين</span>
          <h1>{{\App\User::count()}}</h1>
        </div><!-- Total Users -->

        <!-- Total Books -->
        <div class="col-xs-6 col-md-2 total-books">
          <i class="fa fa-book"></i>
          <span>عدد الكتب</span>
          <h1>{{\App\Book::count()}}</h1>
        </div><!-- Total Users -->

        <!-- Total Comments -->
        <div class="col-xs-6 col-md-2 total-comments">
          <i class="fa fa-comment"></i>
          <span>عدد التعليقات</span>
          <h1>{{\App\Comment::count()}}</h1>
        </div><!-- Total Comments -->

      </div> <!-- Row -->
    </div><!-- Container -->
  </div><!-- statistics -->

  <div class="dashboard">
    <div class="container">
      <div class="row">
        <div class="col-md-6 last-comments">
          <div class="card">
            <div class="card-header">
              أحدث التعليقات
            </div>
            @if(count($lastComments))
              @foreach($lastComments as $comment)
                <!-- comment -->
                <div class="card-body">
                  <h5 class="card-title">
                    <a href="{{route('book.show', $comment->book->slug)}}">{{$comment->book->book_name}}</a>
                  </h5>
                  <p class="card-text">{{$comment->body}}</p>
                  <div class="row">
                    <div class="col-sm-11">
                      <span class="text-muted">تم التعليق بواسطة {{$comment->user->name}}.</span>
                      <span style='display: block;' class='text-muted' dir="ltr">{{$comment->created_at->diffForHumans()}}</span>
                    </div>
                    <div class="col-sm-1">
                      <button @click="removeComment({{$comment->id}}, $event)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </div>
                  </div>
                </div><!-- comment -->
              @endforeach
              <!-- comment -->
              <div class="card-body">
                <h5 class="card-title">
                  <a href="{{route('comments')}}">كل التعليقات</a>
                </h5>
              </div><!-- comment -->
            @else
              <p class="p-2">
                لم يتم اضافة أية تعليقات بعد.
              </p>
            @endif
          </div>
        </div><!-- Last comments -->
        <div class="col-md-6 top-books">
          <div class="card">
            <div class="card-header">
              أبرز الكتب
            </div>
            @if(count($mostBooks))
              @foreach($mostBooks as $book)
                <!-- comment -->
                <div class="card-body">
                  <h5 class="card-title">
                    <a href="{{route('book.show', $book->slug)}}" class='text text-info'>{{$book->book_name}}</a>
                  </h5>
                  <span class="text-muted">{{$book->views}} زيارة</span>
                </div><!-- comment -->
              @endforeach
            @else
              <p class="p-2">
                لم يتم اضافة أية كتب بعد.
              </p>
            @endif
          </div><!-- Card -->
        </div><!-- Top Books -->
      </div><!-- Row -->
    </div><!-- container -->
  </div><!-- dashboard -->
@endsection
