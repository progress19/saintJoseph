<? use App\Fun ?>

<div class="pre-header text-end">
  <span class="no-movil"><a href="mailto:info@saintjosephweb.com.ar">info@saintjosephweb.com.ar</a> | </span><span><i class="fa-brands fa-whatsapp"></i> <a href="tel:542604673443">(0260) 467-3443</a> | <a href="https://www.facebook.com/saintjosephturismoaventura" style="font-size: 15px;" target="new"><i class="fa-brands fa-square-facebook"></i></a></span> 
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" aria-label="Offcanvas navbar large">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('/images/logo.png') }}" class="img-fluid" style="width:120px">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label">
            <img src="{{ asset('/images/logo.png') }}" style="width:150px" class="img-fluid">
          </h5>
          <button type="button" class="btn-close btn-close-whited" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link"  href="{{ route('home') }}#actividades">ACTIVIDADES</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="{{ route('home') }}#grupos">GRUPOS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="{{ route('home') }}#galeria">GALERIA</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="{{ route('home') }}#contacto">CONTACTO</a>
            </li> 
            <li class="nav-item" >
              <a class="nav-link btn-reservas"  href="{{ route('home') }}#actividades"><i class="fa-solid fa-cart-shopping"></i> RESERVAS</a>
            </li>
            <li class="nav-item no-desk">
              <a class="nav-link" href="https://api.whatsapp.com/send?phone=542604673443"><i class="fa-brands fa-whatsapp"></i> (0260) 467-3443</a>              
            </li>
          </ul>
        </div>
      </div>
    </div>
 </nav>