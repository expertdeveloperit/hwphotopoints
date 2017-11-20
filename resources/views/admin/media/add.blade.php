@extends('admin.layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add New Media
        <small>Add New One</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
          @if(Session::has('message'))
              <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif
      <div class="box">
        <form action="{{route('addNewMedia')}}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="box box-primary">
              <div class="box-header with-border">
                <div class="box-body">
                
                </div>
              </div>
          </div>   
          <div class="box-body">
             <div class="box-body pad">
                <input type="file" name="media" required accept="image/x-png,image/gif,image/jpeg">
              </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
          <!-- /.box-footer-->
        </form>  
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


@endsection



