@extends('layouts.admin')
@section('page_title', 'كل العلامات | ')
@section('content')
  <div class="container">
    <add-tag v-if="ShowAddTag" @closeform="ShowAddTag = false"></add-tag>
    <div class="categories">

      <div class="row">
        <h3>
          العلامات
          <button class="btn btn-primary btn-sm" @click="ShowAddTag = true">إضافة جديد</button>
        </h3>
      </div>

      @if(count($tags))
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">العنوان</th>
              <th scope="col">تنفيذ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($tags as $key => $tag)
              <tr>
                <th scope="row">{{$key+1}}</th>
                <td>
                  {{$tag->title}}
                </td>
                <td>
                  <a href="{{route('tag.show', $tag->slug)}}" target="_blank" class="btn btn-success btn-sm">ذهاب</a>
                  <a href="#" @click.prevent="removeTag({{$tag->id}}, $event)" class="btn btn-danger btn-sm">حذف</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        {{$tags->links()}}
      @else
        <p class='alert alert-danger lead mt-3 text-right' style="background: none;">
          انا مش مش عايز اديك..  انا مش لاقي.. هتاكلو الداتابيز يعني!!
        </p>
      @endif
    </div>
  </div>
@endsection
