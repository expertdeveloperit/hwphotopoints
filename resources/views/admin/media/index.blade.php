@extends('admin.layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        All Media
        <small>manage your all media here</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
       @if(Session::has('message'))
              <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif
      <div class="box">
          
        <div class="box-body">
          <span class="copy-alert">Copied</span>
          <div class="content-area">

            <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Image</th>
                  <th>URL(Copy)</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($media as $key=>$img)  
                    <tr>
                      <td>{{$key + 1}}</td>
                      <td>
                        <img style="max-width:100px;" src="{{URL('/uploads/media')}}/{{$img->directory}}/{{$img->name}}">
                      </td>
                      <td>
                        <input type="text" class="urlCopy" value="{{URL('/uploads/media')}}/{{$img->directory}}{{$img->name}}" readonly style="width:100%;">
                      </td>
                      <td>
                        <a class="btn btn-primary" href="{{route('mediaDelete',$img->id)}}">Delete</a>
                      </td>
                    </tr>
                  @endforeach  
                
                </tbody>
               
              </table>
            </div>  
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{ $media->links() }}
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery(".urlCopy").focusin(function(){
        this.select();
        document.execCommand('copy');
        jQuery(".copy-alert").show();
        setTimeout(function(){
          jQuery(".copy-alert").hide();
        },1000);
      });
    });
  </script>
@endsection
