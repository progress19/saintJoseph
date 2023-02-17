 
  <div class="col-md-3 left_col">
    <div class="left_col scroll-view">
      <div class="navbar nav_title" style="border: 0;">

        <div class="logo-login">
          <img src="{{ asset('images/logo.png') }}" class="img-fluid" style="" alt="imagen">
        </div>

      </div>

      <div class="clearfix"></div>

      <!-- menu profile quick info -->
      <div class="profile clearfix">
        <div class="profile_pic">
          <img src="{{ asset('images/default-user.png') }}" alt="..." class="img-circle profile_img">
        </div>
        <div class="profile_info">
          <span>Hola!</span>
          <h2>{{ Auth::user()->name }}</h2>
        </div>
      </div>
      <!-- /menu profile quick info -->

      <br />

      <!-- sidebar menu -->
      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
          <h3>Menú</h3>
          <ul class="nav side-menu">
            
            <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i> Home </a></li>
                             
            <li><a><i class="fa fa-shopping-cart"></i> Reservas <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{ url('/admin/view-reservas') }}"><i class="fa fa-shopping-cart"></i> Ver reservas</a></li>
                {{--<li><a href="{{ url('/admin/exportarReservas') }}"><i class="fa fa-file-excel-o"></i>Exportar Reservas</a></li>--}}
              </ul>
            </li>

            <li><a><i class="fa fa-ticket"></i> Actividades <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{ url('/admin/add-actividad') }}">Nueva actividad</a></li>
                <li><a href="{{ url('/admin/view-actividades') }}">Ver actividades</a></li>
              </ul>
            </li>

            <li><a><i class="fa fa-image"></i> Galería <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{ url('/admin/add-imgHome') }}">Nueva imagen</a></li>
                <li><a href="{{ url('/admin/view-imgsHome') }}">Ver imágenes</a></li>
              </ul>
            </li>

            <li><a><i class="fa fa-users"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
              <ul class="nav child_menu">
                <li><a href="{{ url('/admin/add-usuario') }}">Nuevo Usuario</a></li>
                <li><a href="{{ url('/admin/view-usuarios') }}">Ver usuarios</a></li>
              </ul>
            </li>

            <li><a href="{{ url('/admin/edit-config/1') }}"><i class="fa fa-cog"></i> Configuración</a></li>

          </ul>
        </div>

      </div> 
      <!-- /sidebar menu -->

      <!-- /menu footer buttons -->
      <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ url('/logout') }}" style="width: 100%;">
          <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
      </div>
      <!-- /menu footer buttons -->
    </div>
  </div>

