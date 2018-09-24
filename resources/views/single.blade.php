@extends('layouts.app')
@section('page_title', $book->book_name)
@section('content')
<div class="container">
  <div class="row mt-2">
    <div class="col-lg-9 text-right">
      <h3 class="little-title">
        تحميل {{$book->book_name}}
      </h3>
      <div class="introduction">
        <div class="content">
          <div class="media">
            <img class="ml-3" src="{{asset('storage/' . $book->thumbnail)}}" alt="{{$book->book_name}}" title="{{$book->book_name}}">
            <div class="media-body">
              <h5 class='mb-4'>{{$book->book_name}}</h5>
              @if(!is_null($book->author))
                <p>
                  <span>الكاتب: </span>
                  <a href="{{route('author.show', $book->author->slug)}}">{{$book->author->author_name}}</a>
                </p>
              @endif
              @if(!is_null($book->category))
                <p>
                  <span>القسم: </span>
                  <a href="{{route('category.show', $book->category->slug)}}" target="_blank">{{$book->category->title}}</a>
                </p>
              @endif
              @if(count($book->tags))
                @php
                  $tags = '';
                  foreach($book->tags as $tag){
                    $tags .= '<a href="' . route('tag.show', htmlspecialchars($tag->slug)) . '">' . htmlspecialchars($tag->title) . '</a>، ';
                  }
                  $tags = trim($tags, '، ');
                @endphp
                <p>
                  <span>العلامات: </span>
                  {!!$tags!!}
                </p>
              @endif
            </div>
            <div class="statistics">
              <a href='#downloadBook'>تحميل</a>
              <span>{{$book->views}} مرة مشاهدة</span>
              <span style="color: #1abc9c;">{{$book->downloads}} مرة تحميل</span>
            </div>
          </div>
        </div>
      </div><!-- introduction -->

      <!-- Description -->
      <div class="description">
        <p class="alert alert-danger text-center">
          الملكية الفكرية محفوظة للكاتب المذكور<br />
          إذا كنت تعتقد أن الكتاب ينتهك حق النشر الرجاء إخبارنا على صفحة <a href="{{env('FACEBOOK_PAGE_URI')}}" target="_blank" class="text text-success">الفيسبوك</a> لحذف الكتاب
        </p>
        <h3 class="little-title">عن الكتاب</h3>
        <p class='about'>
        {{$book->book_name}}<br />
        {{$book->description}}<br />
        @if(!is_null($book->author_id))
          جميع الحقوق محفوظة للكاتب: {{$book->author->author_name}}
        @endif
        </p>
        <a href="{{route('book.download', $book->slug)}}">
          <button class="btn btn-success" id="downloadBook">
            تحميل الكتاب PDF
            <i class="fa fa-download"></i>
          </button>
        </a>
      </div><!-- Description -->

      <!-- Comments -->
      <div class="comments mt-4" id="comments">
        @if(count($book->comments))
          <h3 class="little-title">التعليقات</h3>
          @php($comments = $book->comments()->orderBy('id', 'DESC')->paginate(4))
          {{$comments->links()}}
          @foreach($comments->reverse() as $comment)
            <!-- Single Comment -->
            <div class="panel panel-default card">
              <div class="panel-heading card-header">
                <strong>{{$comment->user->name}}</strong>
                @if(Auth::user() && $comment->user_id === Auth::user()->id)
                  <small class='float-left' style="cursor: pointer" @click="deleteComment({{$comment->id}}, $event)">حذف</small>
                @endif
              </div>
              <div class="panel-body card-body">
                {{$comment->body}}
                <div class="text-muted text-left" dir="ltr">{{$comment->created_at->diffForHumans()}}</div>
              </div>
              <!-- /panel-body -->
            </div>
            <!-- Single Comment -->
          @endforeach
        @endif
        <!-- Add a comment -->
        <h4 class="little-title pt-2">أضف تعليقًا</h4>
        @auth
          @if(Session::has('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
          @endif
          <form action="{{route('comment.store', $book->id)}}" method="POST">
            {{csrf_field()}}
            <div class="form-group">
              <label for="your-comment">تعليقك:</label>
              <textarea name="comment" id="your-comment" style="resize: none;" rows="3" class="form-control" placeholder="إجعل أرائك بناءة.">{{old('comment')}}</textarea>
              <a class="text text-danger">{{$errors->first('comment')}}</a>
              <input type="submit" class="btn btn-primary float-left mt-2" value="إضافة">
              <div class="clearfix"></div>
            </div>
          </form>
        @endauth
        @guest
          <div class="alert alert-primary">لإضافة تعليق يجب <a class="text text-info" href="{{url('/')}}#login">تسجيل دخولك</a> بالموقع أولًا</div>
        @endguest
      </div><!-- Comments -->
      @if(!is_null($book->author_id))
        <!-- Related to author -->
        @if(count($relatedByAuthor))
          <div class="related">
            <h4 class="little-title">كتب أخرى للكاتب {{$book->author->author_name}}</h4>
            <div class="row row-eq-height">
              @foreach($relatedByAuthor as $rBook)
                <div class="col-xs-6 col-sm-4 col-md-3">
                  <div class="article">
                    <a href="{{route('book.show', $rBook->slug)}}"><img src="{{asset('storage/' . $rBook->thumbnail)}}" alt="{{$rBook->book_name}}"></a>
                    <a href="{{route('book.show', $rBook->slug)}}">{{$rBook->book_name}}</a>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif<!-- Related to Author -->
      @endif

      @if(!is_null($book->category_id))
        <!-- Related to category -->
        @if(count($relatedByCategory))
          <div class="related">
            <h4 class="little-title">كتب أخرى من قسم {{$book->category->title}}</h4>
            <div class="row row-eq-height">
              @foreach($relatedByCategory as $rBook)
                <div class="col-xs-6 col-sm-4 col-md-3">
                  <div class="article">
                    <a href="{{route('book.show', $rBook->slug)}}"><img src="{{asset('storage/' . $rBook->thumbnail)}}" alt="{{$rBook->book_name}}"></a>
                    <a href="{{route('book.show', $rBook->slug)}}">{{$rBook->book_name}}</a>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif<!-- Related to category -->
      @endif
    </div>
    @include('layouts.sidebar')
  </div><!-- Row -->
</div>
@endsection
