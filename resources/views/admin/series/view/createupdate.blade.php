@extends('admin.layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  

    <!-- Main content -->
    <section class="content">
       @if(isset($editview))   
      
        <section class="content-header">
          <h1>
            Update "{{$post['title']}}" View
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{route('allSeries')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{route('specificSeries',session('seriesName'))}}">{{ucfirst(session('seriesName'))}} Series</a></li>
            <li class="active"><a href="{{route('seriesView',$post['id'])}}">{{$post['title']}}</a></li>
          </ol>
          <br>
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
            <form action="{{route('seriesViewUpdate')}}/{{$post['id']}}/{{$editview['id']}}" method="POST">
              {{ csrf_field() }}
              <div class="box box-primary">
                  <div class="box-header with-border">
                    <div class="box-body">
                      <div class="form-group">
                        <label>Image View</label>
                        <input type="text" name="image_view" value="{{$editview['image_view']}}" class="form-control" id="titile" 
                        placeholder="SIN">
                      </div>
                      <div class="form-group">
                        <label>Value</label>
                        <input type="text" name="value" value="{{$editview['value']}}" class="form-control" id="titile" placeholder="S300">
                      </div>
                      <div class="form-group">
                        <label>Pan View</label>
                        <input type="text" name="pan_view" value="{{$editview['pan_view']}}" class="form-control" id="titile" placeholder="300-360">
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
            Add View
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
            <form action="{{route('seriesViewCreate')}}/{{$post['id']}}" method="POST">
              {{ csrf_field() }}
              <div class="box box-primary">
                  <div class="box-header with-border">
                    <div class="box-body">
                      <div class="form-group">
                        <label>Image View</label>
                        <input type="text" name="image_view" value="{{old('image_view')}}" class="form-control" id="titile" placeholder="SIN">
                      </div>
                      <div class="form-group">
                        <label>Value</label>
                        <input type="text" name="value" value="{{old('value')}}" class="form-control" id="titile" placeholder="S300">
                      </div>
                      <div class="form-group">
                        <label>Pan View</label>
                        <input type="text" name="pan_view" value="{{old('pan_view')}}" class="form-control" id="titile" placeholder="300-360">
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
