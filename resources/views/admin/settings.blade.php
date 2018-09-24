@extends('layouts.admin')
@section('page_title', 'الاعدادات | ')
@section('content')
  <div class="container text-right">
    <label for="language">اللغة: </label>
    <select id="language" class="form-control" style="padding-bottom: 0">
      <option>عربي</option>
      <option style="color: red;">عربي برضو بس بالاحمر</option>
    </select>
  </div>
@endsection
