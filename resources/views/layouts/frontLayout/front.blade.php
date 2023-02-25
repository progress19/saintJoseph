<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf_token" content="{{ csrf_token() }}" />

    <title>Saint Joseph | Turismo Aventura | San Rafael Mendoza</title>

    <meta name="description" content="Descubre la emoción del turismo aventura en San Rafael Mendoza">
    <meta name="keywords" content="rafting, cool river, canopy, tirolesa, catamaran, valle grande, san rafael, mendoza, rafting nocturno ">
    <meta name="author" content="Mauricio Lavilla">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/front_css/galeria.css') }}" />
    {{--<link rel="stylesheet" href="{{ asset('css/front_css/aos.css') }}" />--}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/front_css/lightcase.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/front_css/styles.css') }}"> 

    <link href="{{ asset('css/front_css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front_css/brands.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front_css/solid.min.css') }}" rel="stylesheet">
     
    <link rel="stylesheet" href="{{ asset('css/front_css/cart/style.css') }}">  
    <link rel="stylesheet" href="{{ asset('css/front_css/hover.css') }}"> 

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon_io/site.webmanifest') }}">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4K2X61G1RJ"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-4K2X61G1RJ');
    </script>

</head>

<body>

@yield('content')

@include('_footer')

    {{ Form::hidden('baseUrl', url('/'), array('id' => 'baseUrl')) }}

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    {{--<script type="text/javascript" src=" {{ asset('js/front_js/aos.js') }}"></script>--}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script type="text/javascript" src=" {{ asset('js/front_js/lightcase.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-touch-events/1.0.5/jquery.mobile-events.js"></script>
    <script src="{{ asset('js/front_js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/front_js/scripts.js') }}"></script>

    <!-- CART JS -->
    <script src="{{ asset('js/front_js/cart/cart.js') }}"></script>
    <script src="{{ asset('js/front_js/cart/util.js') }}"></script>
   
<script>

    //menu nav

    $('a[href^="#"]').on('click', function(event) {
    var target = $(this.getAttribute('href'));
    if (target.length) {
      event.preventDefault();
        $('html, body').stop().animate({ scrollTop: target.offset().top - 115 }, 1000); }
      });

    //map    

    function initialize() {

    var locations = [ 
       ['Saint Joseph',  -34.81819192799161, -68.50390908625253, 1, ''],  
    ];

    window.map2 = new google.maps.Map(document.getElementById('google-map2'), {
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false,
        navigationControl: false,
        center: {lat: -34.81819192799161, lng:  -68.50390908625253 }, 
        zoom: 12

    });

    var infowindow = new google.maps.InfoWindow();
    var bounds = new google.maps.LatLngBounds();

    for (i = 0; i < locations.length; i++) {

        marker = new google.maps.Marker({
            position: new google.maps.LatLng( locations[i][1], locations[i][2] ),
            map: map2,
            //icon: '<?php echo asset('/images/map.png') ?>'
        });


        bounds.extend(marker.position);
        google.maps.event.addListener(marker, 'click', (function (marker, i, info) {
            return function () {

                var info = '<div style="color:#000" >'+
                  '<p class="mb-0"><b>' + locations[i][0] + '</b></p>'+
                  '<p class="mb-0">Ruta Provincial 173 KM 28.5</p>'
                  '</div>';

                infowindow.setContent( info );
                infowindow.open(map2, marker);
            
            }
        })(marker, i));

    }

}

function loadScript() {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBBhh9bdv02x8XPknaSceyUsPFrz6ap4SE&sensor=false&' + 'callback=initialize';

    document.body.appendChild(script);
}

window.onload = loadScript;
    
</script>
  
</body>

@yield('page-js-script')

</html>

