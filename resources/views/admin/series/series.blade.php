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
       <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">{{ucfirst(session('seriesName'))}} Series</a></li>
            
          </ol>
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
                  <th>Start Year</th>
                 <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($series as $key=>$series)  
                <tr>
                  <td>{{$key + 1}}</td>
                  <td>{{$series['name']}}</td>
                  <td>{{$series['start_year']}}</td>    
                  <th> <a class="btn bg-green btn-flat margin" href="{{route('editMainSeries',$series['id'])}}">Update</a></th>                
                </tr>
                @endforeach
                </tbody>
               
              </table>
            @else
              <h4>{{"Series doesn't exist"}}  </h4>
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
