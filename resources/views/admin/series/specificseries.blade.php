@extends('admin.layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ucfirst($seriesName)}} Series
        <small>manage your series</small>
      </h1>
       <ol class="breadcrumb">
            <li><a href="{{route('allSeries')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">{{ucfirst(session('seriesName'))}} Series</a></li>
            
          </ol>
    </section>
    <br>
    <!-- Main content -->
    <section class="content">

      <div class="box">
        
        <div class="box-body">
           @if(Session::has('message'))
              <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
           <div class="form-group">
              <a class="btn bg-green btn-flat margin" href="{{route('addNewSeries',$seriesName)}}">Add New</a>
            </div>
          @if($data->count() > 0)
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Action</th>
                  @if($seriesName == "p")
                    <th>View</th>
                  @endif
                </tr>
                </thead>
                <tbody>

                @foreach($data as $key=>$series)  
                <tr>
                  <td>{{$key + 1}}</td>
                  <td>{{$series['title']}}</td>
                  <td>{{$series['year']}}</td> 
                  <td>
                    <a class="btn bg-green btn-flat margin" href="{{route('editSeries')}}/{{$series['id']}}">Edit</a>
                    <a class="btn bg-red btn-flat margin" href="{{route('deleteSeries')}}/{{$seriesName}}/{{$series['id']}}">Delete</a>
                  </td>                                       
                  @if($seriesName == "p")
                    <td>
                      <a class="btn bg-red btn-flat margin" href="{{route('seriesView')}}/{{$series['id']}}">Manage View</a>  
                    </td>
                  @endif
                </tr>
                @endforeach
                </tbody>
               
              </table>
            @else
              <h4>{{"No post found"}}  </h4>
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
