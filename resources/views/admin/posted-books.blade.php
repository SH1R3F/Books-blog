@extends('layouts.admin')
@section('page_title', 'كل الكتب | ')
@section('content')
  <div class="container">
    <div class="posted_books">
      <div class="row">
        <div class="col-sm-8 text-right">
          <h3>
            الكتب المنشورة
            <a href="{{route('book.create')}}" class="btn btn-primary btn-sm">إضافة جديد</a>
          </h3>
        </div>
        @if(count($books))
          <div class="col-sm-4">
            <input type="text" class="form-control" placeholder="بحث عن كتاب">
          </div>
        @endif
      </div>
      @if(Session::has('success'))
        <div class="alert alert-success text-right">{{Session::get('success')}}</div>
      @endif
      @if(count($books))
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">العنوان</th>
              <th scope="col">الناشر</th>
              <th scope="col">التصنيف</th>
              <th scope="col">علامات مخصصة</th>
              <th scope="col">تنفيذ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($books as $key => $book)
              <tr>
                <th scope="row">{{$key+1}}</th>
                <td>
                  {{$book->book_name}}
                </td>
                <td>{{$book->user->name}}</td>
                <td>{{$book->category['title']}}</td>
                <td>
                  @php
                    $tags = '';
                    foreach($book->tags as $tag){
                      $tags .= '<a href="' . route('tag.show', $tag->id) . '">' . htmlspecialchars($tag->title) . '</a>, ';
                    }
                    $tags = trim($tags, ', ');
                  @endphp
                  {!!$tags!!}
                </td>
                <td style='min-width: 175px;'>
                  <a href="{{route('book.show', $book->slug)}}" target="_blank" class="btn btn-success btn-sm">معاينة</a>
                  <a href="{{route('book.edit', $book->id)}}" class="btn btn-primary btn-sm {{Auth::user()->hasRole('superadministrator|administrator|author') || (Auth::user()->hasRole('editor') && ($book->user->id === Auth::user()->id)) ? '': 'disabled'}}">تعديل</a>
                  <a href="#" @click.prevent="removeBook({{$book->id}}, $event)" class="btn btn-danger btn-sm {{Auth::user()->hasRole('superadministrator|administrator|author') || (Auth::user()->hasRole('editor') && ($book->user->id === Auth::user()->id)) ? '': 'disabled'}}">حذف</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        {{$books->links()}}
      @else
        <p class='alert alert-danger lead mt-3 text-right' style="background: none;">
          مفيش كتب متضافة يارايق.
        </p>
      @endif
    </div>
  </div>
@endsection
