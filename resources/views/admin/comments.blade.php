@extends('layouts.admin')
@section('page_title', 'كل التعليقات | ')
@section('content')
  <div class="container">
    <div class="categories">
      <div class="row">
        <h3>
          التعليقات
        </h3>
      </div>
      @if(count($comments))
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">الكتاب</th>
              <th scope="col">التعليق</th>
              <th scope="col">تنفيذ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($comments as $key => $comment)
              <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$comment->book->book_name}}</td>
                <td style="max-width: 650px">{{$comment->body}}</td>
                <td>
                  <a href="{{route('book.show', $comment->book->slug)}}" class="btn btn-success btn-sm">ذهاب</a>
                  <a href="#" @click.prevent="deleteComment({{$comment->id}}, $event)" class="btn btn-danger btn-sm">حذف</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        {{$comments->links()}}
      @else
        <p class='alert alert-danger lead mt-3 text-right' style="background: none;">
          مفيش تعليقات لسة اهو يامسهل.. لم علينا عبيدك يارب.
        </p>
      @endif

    </div>
  </div>
@endsection
