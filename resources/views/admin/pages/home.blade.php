@extends('admin.layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        All Pages
        <small>manage your all pages here</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box">
        
        <div class="box-body">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($allPages as $key=>$page)  

                <tr>
                  <td>{{$key + 1}}</td>
                  <td>{{$page['title']}}</td>
                  <td>{{substr(strip_tags($page['description']), 0, 50)}}..</td>    
                  <td><a href="">Edit</a></td>                  
                </tr>
                @endforeach
                </tbody>
               
              </table>
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
