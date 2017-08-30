@extends('admin.layout.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Page
        <small>Add New One</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box">
        <form action="{{route('addNeworUpdate')}}/{{$page['id']}}" method="POST">
          {{ csrf_field() }}
          <div class="box box-primary">
              <div class="box-header with-border">
                <div class="box-body">
                  <div class="form-group">
                    <input value="{{$page['title']}}" type="text" name="title" class="form-control" id="titile" placeholder="Page Title">
                  </div>
                </div>
              </div>
          </div>   
          <div class="box-body">
             <div class="box-body pad">
                <textarea id="editor" name="editor" rows="10" cols="80">
                    {{$page['description']}}
                </textarea>
              </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
          <!-- /.box-footer-->
        </form>  
        
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor')
    //bootstrap WYSIHTML5 - text editor

  })
</script>
@endsection



