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
          @if(!$series->isEmpty())
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Title</th>
                  <th>Description</th>
                 
                </tr>
                </thead>
                <tbody>

                @foreach($series as $key=>$series)  
                <tr>
                  <td>{{$key + 1}}</td>
                  <td>{{$series['name']}}</td>
                  <td>{{substr(strip_tags($series['description']), 0, 50)}}..</td>    
                                  
                </tr>
                @endforeach
                </tbody>
               
              </table>
            @else
              {{"Series doesn't exist"}}  
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
