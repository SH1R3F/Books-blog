@extends('layouts.admin')
@section('page_title', 'كل التصنيفات | ')
@section('content')
  <div class="container">
    <add-category v-if="ShowAddCategory" @closeform="ShowAddCategory = false"></add-category>
    <div class="categories">

      <div class="row">
        <h3>
          التصنيفات
          <button class="btn btn-primary btn-sm" @click="ShowAddCategory = true">إضافة جديد</button>
        </h3>
      </div>
      @if(count($categories))
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">العنوان</th>
              <th scope="col">تنفيذ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($categories as $key => $category)
              <tr>
                <th scope="row">{{$key+1}}</th>
                <td>
                  {{$category->title}}
                </td>
                <td>
                  <a href="{{route('category.show', $category->slug)}}" target="_blank" class="btn btn-success btn-sm">ذهاب</a>
                  <a href="#" @click.prevent="removeCategory({{$category->id}}, $event)" class="btn btn-danger btn-sm">حذف</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        {{$categories->links()}}
      @else
        <p class='alert alert-danger lead mt-3 text-right' style="background: none;">
          مفيش تصنيفات اجيبلك جرجير؟
        </p>
      @endif
    </div>
  </div>
@endsection
