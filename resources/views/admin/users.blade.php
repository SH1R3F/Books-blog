@extends('layouts.admin')
@section('page_title', 'كل المستخدمين | ')
@section('content')
  <div class="container">
    <update-userrole @closeform="UpdateUserRole = false" v-if="UpdateUserRole" roles="{{json_encode($roles)}}" :user="ChangeUserIs"></update-userrole>
    <div class="categories">
      <div class="row">
        <h3>
          المستخدمين
        </h3>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">الاسم</th>
            <th scope="col">البريد الالكتروني</th>
            <th scope="col">المسئولية</th>
            <th scope="col">تاريخ الانشاء</th>
            <th scope="col">تنفيذ</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $key => $user)
            <tr>
              <th scope="row">{{$key+1}}</th>
              <td>{{$user->name}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->roles[0]->display_name}}</td>
              <td>{{$user->created_at->toFormattedDateString()}}</td>
              <td>
                <a href="#" @click.prevent="UpdateUserRole = true; ChangeUserIs = {{json_encode([$user->id, $user->roles[0]->id])}};" class="btn btn-primary btn-sm {{($user->hasRole('superadministrator') || !Auth::user()->hasRole('superadministrator|administrator')) ? 'disabled': ''}}" :disabled="UpdateUserRole">ترقية</a>
                <a href="#" @click.prevent="removeUser({{$user->id}}, $event)" class="btn btn-danger btn-sm {{( $user->hasRole('superadministrator') || !Auth::user()->hasRole('superadministrator|administrator') ) ? 'disabled' : ''}}">حذف</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {{$users->links()}}
    </div>
  </div>
@endsection
