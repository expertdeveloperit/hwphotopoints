@extends('admin.layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      
       <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{route('usersList')}}">Users</a></li>
       </ol>
    </section>

    <!-- Main content -->
    <section class="content">
       @if(isset($user))   
      
        <section class="content-header">
          <h1>
            Update User            
          </h1>
        </section>
        <div class="box">
          <div class="box-body">
            @if(Session::has('message'))
              <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            @if (Session::has('error'))
                <div class="error">
                  <h3 style="color:red">{{ Session::get('error') }}</h3>
                </div>
            @endif


            <form action="{{route('userUpdate')}}/{{$user['id']}}" method="POST">
              {{ csrf_field() }}
              <div class="box box-primary">
                  <div class="box-header with-border">
                    <div class="box-body">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{$user['name']}}" class="form-control" id="title" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" value="{{$user['email']}}" class="form-control" id="title" placeholder="Email">
                      </div>
                      
                      <div class="form-group">
                        <label>Role</label>
                        <select name="role"  class="form-control">
                          <option @if($user->userMeta->role == '1') {{'selected'}} @endif value="1">Admin</option>
                          <option @if($user->userMeta->role == '2') {{'selected'}} @endif value="2">Photographer</option>
                          <option @if($user->userMeta->role == '3') {{'selected'}} @endif value="3">Subscriber</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>User Status</label>
                        <select name="status"  class="form-control">
                           <option  value="">Select</option>
                          <option @if($user->userMeta->status == '1') {{'selected'}} @endif value="1">Active</option>
                          <option @if($user->userMeta->status == '2') {{'selected'}} @endif value="2">Deactivate</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Update Password</label>
                        <input type="text" name="password" value="" class="form-control" id="title" placeholder="Password">
                      </div>
                    </div>
                  </div>
              </div>                 
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
            <!-- /.box-footer-->
          </form>  
          </div>
        </div>
        <!-- /.box -->
      @else
        <section class="content-header">
          <h1>
            Add New User
            <small>Add New One</small>
          </h1>
          @if(Session::has('message'))
              <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif
          @if (Session::has('error'))
              <div class="error">
                <h3 style="color:red">{{ Session::get('error') }}</h3>
              </div>
          @endif
        </section>
        <div class="box">
          <div class="box-body">
            <form action="{{route('userUpdate')}}" method="POST">
              {{ csrf_field() }}
              <div class="box box-primary">
                  <div class="box-header with-border">
                    <div class="box-body">
                     <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="" class="form-control" id="title" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" value="" class="form-control" id="title" placeholder="Email">
                      </div>
                     
                       <div class="form-group">
                        <label>Role</label>
                        <select name="role" value="" class="form-control">
                          <option  value="1">Admin</option>
                          <option  value="2">Photographer</option>
                          <option  value="3">subscriber</option>
                        </select>                        
                      </div>

                      <div class="form-group">
                        <label>User Status</label>
                        <select name="status"  class="form-control">
                          <option  value="">Select</option>
                          <option  value="1">Active</option>
                          <option  value="2">Deactivate</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Update Password</label>
                        <input type="text" name="password" value="" class="form-control" id="title" placeholder="Password">
                      </div>
                    </div>
                  </div>
              </div>                 
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <!-- /.box-footer-->
          </form>  
          </div>
        </div>
        <!-- /.box -->
      @endif  
    </section>  
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
