@extends('admin.layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <input type="hidden" id="sortUrl" value="{{URL::to('/')}}/admin/series/views/order/sort">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$post['title']}} Views List
        <small>manage your views</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('allSeries')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('specificSeries',session('seriesName'))}}">{{ucfirst(session('seriesName'))}} Series</a></li>
        <li class="active"><a href="#">{{$post['title']}}</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box">
        <div class="form-group">
              <a class="btn bg-green btn-flat margin" href="{{route('seriesViewEdit',$post['id'])}}">Add New</a>
        </div>  
        <div class="box-body">
          <p class="ajax-alert alert-info"></p>
          @if(Session::has('message'))
              <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif

          @if(!$views->isEmpty())
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th></th>
                  <th>S.No</th>
                  <th>Post Name</th>
                  <th>Image View</th>
                  <th>Value</th>
                  <th>Pan View</th>
                  <th>Action</th> 
                </tr>
                </thead>
                <tbody id="sortable">

                @foreach($views as $key=>$view)  
                <tr class="ui-state-default" id-data="{{$view['id']}}">
                  <td><i class="fa fa-arrows" aria-hidden="true"></i></td>
                  <td>{{$key + 1}}</td>
                  <td>{{$post['title']}}</td>
                  <td>{{$view['image_view']}}</td>
                  <td>{{$view['value']}}</td>
                  <td>{{$view['pan_view']}}</td>
                  <td>
                    <a class="btn bg-green btn-flat margin" href="{{route('seriesViewEdit')}}/{{$post['id']}}/{{$view['id']}}">Edit</a>
                    <a class="btn bg-red btn-flat margin" href="{{route('seriesViewDelete')}}/{{$post['id']}}/{{$view['id']}}">Delete</a>
                  </td> 
                </tr>
                @endforeach
                </tbody>
               
              </table>
            @else
              <h4>{{"View doesn't exist"}}  </h4>
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

  <script type="text/javascript">
    jQuery( function() {
    jQuery( "#sortable" ).sortable({
    stop: function( event, ui ) {
      var array = [];
      var ids = jQuery("#sortable tr").each(function() {
        var data = jQuery(this).attr("id-data");
          array.push(data);
      });   
      var url = jQuery("#sortUrl").val();
      jQuery.ajax({
        type: "POST",
        url: url,
        data: {data:array,"_token": "{{ csrf_token() }}"},
        dataType: "json",
        success: function(resultData) { 
            jQuery(".ajax-alert").html("View sort has been updated.");
            setTimeout(function(){
              jQuery(".ajax-alert").html("");
            },1500);
        }
      });
      
    }
    });
    
  } );

  </script>

@endsection

