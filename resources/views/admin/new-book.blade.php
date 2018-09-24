@extends('layouts.admin')
@section('page_title', 'كتاب جديد | ')
@section('content')
  <div class="new-book mt-5 text-right">
    <div class="container">
      <add-category v-if="ShowAddCategory" @closeform="ShowAddCategory = false"></add-category>
      <add-tag v-if="ShowAddTag" @closeform="ShowAddTag = false"></add-tag>
      <add-author v-if="ShowAddAuthor" @closeform="ShowAddAuthor = false"></add-author>

      <form action="{{route('book.store')}}" method="POST" enctype="multipart/form-data">

        {{ csrf_field() }}

        <div class="form-group">
          <label for="title">العنوان:</label>
          <input type="text" id="title" name="title" class="form-control" placeholder="أكتب عنوان الكتاب" value="{{old('title')}}" />
          <a class="text text-danger">{{$errors->first('title')}}</a>
        </div>

        <div class="form-group">
          <label for="description">الوصف:</label>
          <textarea name="description" id="description" rows="8" class="form-control" placeholder="ضع وصفًا للكتاب">{{old('description')}}</textarea>
          <a class="text text-danger">{{$errors->first('description')}}</a>
        </div>

        <div class="form-group">
          <label for="thumbnail">صورة الكتاب:</label>
          <input type="file" id="thumbnail" name="thumbnail" class="form-control">
          <a class="text text-danger">{{$errors->first('thumbnail')}}</a>
        </div>

        <div class="form-group">
          <label for="category">التصنيف:</label>
          <button class="btn btn-primary btn-sm" @click.prevent="ShowAddCategory = true">إضافة جديد</button>
          <select name="category" id="category" class="form-control">
            <option value {{old('category') ? '': 'selected'}}>لا يوجد تصنيف</option>
            @foreach($categories as $category)
              <option value="{{$category->id}}" {{old('category') == $category->id ? 'selected' : ''}}>{{$category->title}}</option>
            @endforeach
          </select>
          <a class="text text-danger">{{$errors->first('category')}}</a>
        </div>

        <div class="form-group">
          <label for="tags">العلامات:</label>
          <button class="btn btn-primary btn-sm" @click.prevent="ShowAddTag = true">إضافة جديد</button>
          <select name="tags[]" id="tags" class="js-example-basic-multiple form-control" multiple>
            @foreach($tags as $tag)
              <option value="{{$tag->id}}">{{$tag->title}}</option>
            @endforeach
          </select>
          <a class="text text-danger">{{$errors->first('tags')}}</a>
        </div>

        <div class="form-group">
          <label for="author">الكاتب:</label>
          <button class="btn btn-primary btn-sm" @click.prevent="ShowAddAuthor = true">إضافة جديد</button>
          <select name="author" id="author" class="form-control">
            <option value {{old('author') ? '': 'selected'}}>غير معرف</option>
            @foreach($authors as $author)
              <option value="{{$author->id}}" {{old('author') == $author->id ? 'selected' : ''}}>{{$author->author_name}}</option>
            @endforeach
          </select>
          <a class="text text-danger">{{$errors->first('author')}}</a>
        </div>

        <div class="form-group">
          <label for="book-file">الكتاب:</label>
          <input type="file" class="form-control" id="book-file" name="bookFile">
          <a class="text text-danger">{{$errors->first('bookFile')}}</a>
        </div>

        <div class="form-group pt-4">
          <input type="submit" class="btn btn-success" value="رفع الكتاب">
        </div>

      </form>
    </div>
  </div>
@endsection
@section('footer_scripts')
  <script>
    $(document).ready(function(){
      $("#tags").select2();
      $("#tags").select2().val(@json(old('tags'))).trigger('change');
    })
  </script>
@endsection
