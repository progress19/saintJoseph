<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Saint Joseph | BackOffice</title>

    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('vendors/animate.css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('css/back_css/custom.css') }}" rel="stylesheet">

    <!-- Toast -->
    <link href="{{ asset('vendors/toast/jquery.toast.css') }}" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">

            @if (Session::has('flash_message_error'))
              <div class="alert alert-error alert-block">
                <buttom type="buttom" class="close" data-dismiss="alert">x</buttom>
                {!! session('flash_message_error') !!} 
              </div>   
            @endif

            @if (Session::has('flash_message_success'))
              <div class="alert alert-error alert-block">
                <buttom type="buttom" class="close" data-dismiss="alert">x</buttom>
                {!! session('flash_message_success') !!} 
              </div>   
            @endif

            <form id="loginform" method="post" action="{{ url('admin') }}">{{ csrf_field() }}

              <h1>LOGIN</h1>
              <div>
                <input type="email" class="form-control" name="email" placeholder="Usuario" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" required="" />
              </div>
              <div>

                <button type="submit" class="btn btn-dark" style="padding: 10px 25px;"><i class="fa fa-sign-in"></i> INICIAR SESION</button>
                
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />
                  
                  <div class="logo-login">
                  
                    <a href="http://www.saintjosephweb.com.ar" class="new">
                      <img src="{{ asset('images/logo.png') }}" width="140px" class="img-fluid" style="" alt="imagen">
                    </a>

                    <h2>Versión 1.0</h2>  
                    <h2>Desarrollado por <a href="https://mauriciolavilla.ml" target="_new">Mauricio Lavilla</a></h2>
                    <h2>©2023 Todos los derechos reservados.</h2>

                  </div>

              </div>
            </form>
          </section>
        </div>

      </div>
    </div>

<script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('vendors/toast/jquery.toast.js') }}"></script>
<!-- Custom Theme Scripts -->
<script src="{{ asset('js/back_js/custom.js') }}"></script>


@if (session('flash_message'))
  <script>toast('{!! session('flash_message') !!}');</script>
@endif

  </body>
</html>
