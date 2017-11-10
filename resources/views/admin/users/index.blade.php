@extends('admin.layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        All Users
        <small>manage your users here.</small>
      </h1>
       <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Users</a></li>
       </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box">
        @if(Session::has('message'))
              <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
        <div class="box-body">
          @if(!$users->isEmpty())
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($users as $key=>$user)  

                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>    
                  <td>@if(isset($user->userMeta)) @if($user->userMeta->role == "1") {{'Super Admin'}} @elseif($user->userMeta->role == "2") {{'Photographer'}} @elseif($user->userMeta->role == "3") {{'Visitor'}} @endif @endif</td>                  
                   <td>
                    <a class="btn bg-green btn-flat margin" href="{{route('usersEdit',$user['id'])}}">Edit</a>
                    <a class="btn bg-red btn-flat margin" href="{{route('usersDelete',$user['id'])}}">Delete</a>
                  </td>
                </tr>
                @endforeach
                </tbody>
               
              </table>
            @else
              <h4>{{"Users doesn't exist"}}  </h4>
            @endif  
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>  
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
