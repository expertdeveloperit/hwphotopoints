@extends('admin.layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Series
        <small>manage your all pages here</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box">
        
        <div class="box-body">
          @if(!$data->isEmpty())
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

                @foreach($data as $key=>$series)  
                <tr>
                  <td>{{$key + 1}}</td>
                  <td>{{$series['title']}}</td>
                  <td>{{$series['year']}}</td> 
                  <td>
                    <a class="btn bg-olive btn-flat margin" href="{{route('editSeries')}}/{{$series['id']}}">Edit</a>
                    <a class="btn bg-red btn-flat margin" href="{{route('deleteSeries')}}/{{$series['id']}}">Delete</a>
                  </td>                                       
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
