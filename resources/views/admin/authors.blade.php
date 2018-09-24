@extends('layouts.admin')
@section('page_title', 'كل الكتاب | ')
@section('content')
  <div class="container">
    <add-author v-if="ShowAddAuthor" @closeform="ShowAddAuthor = false"></add-author>
    <div class="categories">

      <div class="row">
        <h3>
          الكُتاب
          <button class="btn btn-primary btn-sm" @click="ShowAddAuthor = true">إضافة جديد</button>
        </h3>
      </div>

      @if(count($authors))
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">الاسم</th>
              <th scope="col">تنفيذ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($authors as $key => $author)
              <tr>
                <th scope="row">{{$key+1}}</th>
                <td>
                  {{$author->author_name}}
                </td>
                <td>
                  <a href="{{route('author.show', $author->slug)}}" class="btn btn-success btn-sm">ذهاب</a>
                  <a href="#" @click.prevent="removeAuthor({{$author->id}}, $event)" class="btn btn-danger btn-sm">حذف</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        {{$authors->links()}}
      @else
        <p class='alert alert-danger lead mt-3 text-right' style="background: none;">
            مفيش كُتَاب متضافين يصحب
        </p>
      @endif

    </div>
  </div>
@endsection
