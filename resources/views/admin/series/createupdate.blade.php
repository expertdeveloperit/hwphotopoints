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
            <form action="{{route('updateSeries')}}/{{$editseries['id']}}" method="POST">
              {{ csrf_field() }}
              <div class="box box-primary">
                  <div class="box-header with-border">
                    <div class="box-body">
                      <div class="form-group">
                        <label>Post Title</label>
                        <input type="text" name="title" value="{{$editseries['title']}}" class="form-control" id="titile" placeholder="Series Title">
                      </div>
                      <div class="form-group">
                        <label>Year</label>
                        <input type="text" name="year" value="{{$editseries['year']}}" class="form-control" id="titile" placeholder="2019">
                      </div>
                      <?php 
                      $string = $editseries['title'];
                      $seriesTitle = substr($string, 0, 1); 

                      ?>
                      <div class="form-group @if($seriesTitle != 'p' && $seriesTitle != 'P') hidden  @endif">
                        <label>View Order</label>

                        <select name="ordertype"  class="form-control">
                          <option>Select</option>
                          <option value="desc" @if($editseries['description'] == 'desc') selected @endif>SIN to PAN</option>
                          <option value="asc" @if($editseries['description'] == 'asc') selected @endif>PAN to SIN</option>
                        </select>
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
            Add {{ucfirst($seriesName)}} Series Post
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
            <form action="{{route('createNewSeries',$seriesName)}}" method="POST">
              {{ csrf_field() }}
              <div class="box box-primary">
                  <div class="box-header with-border">
                    <div class="box-body">
                      <div class="form-group">
                        <label>Post Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control" id="titile" placeholder="Series Title">
                      </div>
                      <div class="form-group">
                        <label>Year</label>
                        <input type="textarea" name="year" value="{{ old('year') }}" class="form-control" id="titile" placeholder="Description">
                      </div>

                      <div class="form-group @if($seriesName != 'p') hidden  @endif"> 
                        <label>View Order</label>
                        <select name="ordertype" class="form-control">
                          <option>Select</option>
                          <option value="desc">SIN to PAN</option>
                          <option value="asc" >PAN to SIN</option>
                        </select>
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
