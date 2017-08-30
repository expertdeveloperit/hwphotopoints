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
            <form action="{{route('updateSeries')}}/{{$editseries['id']}}" method="POST">
              {{ csrf_field() }}
              <div class="box box-primary">
                  <div class="box-header with-border">
                    <div class="box-body">
                      <div class="form-group">
                        <label>Post Name</label>
                        <input type="text" name="title" value="{{$editseries['title']}}" class="form-control" id="titile" placeholder="Series Name">
                      </div>
                      <div class="form-group">
                        <label>Year</label>
                        <input type="text" name="year" value="{{$editseries['year']}}" class="form-control" id="titile" placeholder="2019">
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
        </section>
        <div class="box">
          <div class="box-body">
            <form action="{{route('createNewSeries')}}" method="POST">
              {{ csrf_field() }}
              <div class="box box-primary">
                  <div class="box-header with-border">
                    <div class="box-body">
                      <div class="form-group">
                        <label>Post Name</label>
                        <input type="text" name="name" class="form-control" id="titile" placeholder="Series Name">
                      </div>
                      <div class="form-group">
                        <label>Year</label>
                        <input type="textarea" name="description" class="form-control" id="titile" placeholder="Description">
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
