@extends('admin.layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  

    <!-- Main content -->
    <section class="content">
       @if(isset($editseries))   
      
        <section class="content-header">
          <h1>
            Update Series
            
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
            <form action="{{route('updateMainSeries',$editseries['id'])}}" method="POST">
              {{ csrf_field() }}
              <div class="box box-primary">
                  <div class="box-header with-border">
                    <div class="box-body">
                      <div class="form-group">
                        <label>Post Title</label>
                        <input type="text" name="title" value="{{$editseries['name']}}" class="form-control" id="titile" placeholder="Series Title" readonly>
                      </div>
                      <div class="form-group">
                        <label> Start Year</label>
                        <input type="text" name="year" value="{{$editseries['start_year']}}" class="form-control" id="titile" placeholder="Start Year">
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
            Add New Series
            <small>Add New One</small>
          </h1>
        
          @if (Session::has('error'))
              <div class="error">
                <h3 style="color:red">You can't add new one.</h3>
              </div>
          @endif
        </section>
       
      @endif  
    </section>  
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
