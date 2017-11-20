<!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview {{ (Request::is('admin/media'. '*') ? 'active' : '') }}">
          <a href="#">
            <i class="fa fa-user"></i> <span>Media</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('mediaView')}}"><i class="fa fa-circle-o"></i> Media</a></li>
            <li><a href="{{route('mediaAddView')}}"><i class="fa fa-circle-o"></i> Add New</a></li>
          </ul>
        </li>

        <li class="treeview {{ (Request::is('admin/page'. '*') ? 'active' : '') }}">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>Pages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('createOrEdit')}}"><i class="fa fa-circle-o"></i> Add New</a></li>
            <li><a href="{{route('allPages')}}"><i class="fa fa-circle-o"></i> All Pages</a></li>
          </ul>
        </li>
        <li class="treeview {{ (Request::is('admin/series'. '*') ? 'active' : '') }}">
          <a href="#">
            <i class="fa fa-files-o"></i> <span>Manage Series</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('allSeries')}}"><i class="fa fa-circle-o"></i> All Series</a></li>
            <li><a href="{{route('specificSeries')}}/p"><i class="fa fa-circle-o"></i> P Series</a></li>
            <li><a href="{{route('specificSeries')}}/s"><i class="fa fa-circle-o"></i> S Series</a></li>
            <li><a href="{{route('specificSeries')}}/l"><i class="fa fa-circle-o"></i> L Series</a></li>
          </ul>
        </li>
        <li class="treeview {{ (Request::is('admin/user'. '*') ? 'active' : '') }}">
          <a href="#">
            <i class="fa fa-user"></i> <span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('usersList')}}"><i class="fa fa-circle-o"></i> All Users</a></li>
            <li><a href="{{route('usersCreate')}}"><i class="fa fa-circle-o"></i> Add New</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>