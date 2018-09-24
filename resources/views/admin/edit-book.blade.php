@extends('layouts.admin')
@section('page_title', "تعديل {$book->book_name} | ")
@section('content')
  <div class="new-book mt-5 text-right">
    <div class="container">
      <add-category v-if="ShowAddCategory" @closeform="ShowAddCategory = false"></add-category>
      <add-tag v-if="ShowAddTag" @closeform="ShowAddTag = false"></add-tag>
      <add-author v-if="ShowAddAuthor" @closeform="ShowAddAuthor = false"></add-author>
      <form action="{{route('book.update', $book->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        {{ csrf_field() }}
        <div class="form-group">
          <label for="title">العنوان:</label>
          <input type="text" id="title" name="title" class="form-control" placeholder="أكتب عنوان الكتاب" value="{{$book->book_name}}" />
        </div>

        <div class="form-group">
          <label for="description">الوصف:</label>
          <textarea name="description" id="description" rows="8" class="form-control" placeholder="ضع وصفًا للكتاب">{{$book->description}}</textarea>
        </div>

        <div class="form-group">
          <label for="thumbnail">صورة الكتاب:</label>
          <a class="text text-info">اترك هذا الحقل فارغًا إذا كنت لا تريد تغييره.</a>
          <input type="file" id="thumbnail" name="thumbnail" class="form-control">
          <a class="text text-danger">{{$errors->first('thumbnail')}}</a>
        </div>

        <div class="form-group">
          <label for="category">التصنيف:</label>
          <button class="btn btn-primary btn-sm" @click.prevent="ShowAddCategory = true">إضافة جديد</button>
          <select name="category" id="category" class="form-control">
            <option value {{is_null($book->category_id) ? '' : 'selected'}}>لا يوجد تصنيف</option>
            @foreach($categories as $category)
              <option value="{{$category->id}}" {{$book->category_id === $category->id ? 'selected': ''}}>{{$category->title}}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="tags">العلامات:</label>
          <button class="btn btn-primary btn-sm" @click.prevent="ShowAddTag = true">إضافة جديد</button>
          <select class="form-control" name="tags[]" id="tags" multiple="multiple">
            @foreach($tags as $tag)
              <option value="{{$tag->id}}">{{$tag->title}}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="author">الكاتب:</label>
          <button class="btn btn-primary btn-sm" @click.prevent="ShowAddAuthor = true">إضافة جديد</button>
          <select name="author" id="author" class="form-control">
            <option value {{is_null($book->author_id) ? '' : 'selected'}}>غير معرف</option>
            @foreach($authors as $author)
              <option value='{{$author->id}}' {{$author->id === $book->author_id ? 'selected': ''}}>{{$author->author_name}}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="book-file">الكتاب:</label>
          <a class="text text-info">اترك هذا الحقل فارغًا إذا كنت لا تريد تغييره.</a>
          <input type="file" class="form-control" id="book-file" name="bookFile">
          <a class="text text-danger">{{$errors->first('bookFile')}}</a>
        </div>

        <div class="form-group pt-4">
          <input type="submit" class="btn btn-success" value="حفظ التعديل">
        </div>

      </form>
    </div>
  </div>
@endsection
@section('footer_scripts')
  <script>
    $(document).ready(function(){
      $("#tags").select2();
      $("#tags").select2().val(@json($book->tags()->allRelatedIds())).trigger('change')
    })
  </script>
@endsection
