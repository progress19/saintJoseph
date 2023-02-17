@extends('layouts.frontLayout.front')
@section('title', 'Saint Joseph Turismo Aventura - Home')    
@include('_nav') 

@section('content')

<div id="home">
  <div class="vimeo-wrapper">
    {{--<iframe src="https://player.vimeo.com/video/796327738?background=0&autoplay=1&loop=1&byline=0&title=0&muted=1" muted="muted" allow="autoplay; fullscreen" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen>
      </iframe> --}}

</div>
  <div class="conte-mute d-none ">
    <a class="audio-mute icon-round"><i class="fas fa-volume-mute"></i></a>
    <a class="audio-unmute icon-round displayNone"><i class="fas fa-volume-up"></i></a>   
  </div>
</div>


@include('_actividades')
@include('_grupos')
@include('_galeria') 
@include('_contacto')
@include('_carrito')

@endsection

@section('page-js-script')

<script src="https://player.vimeo.com/api/player.js"></script>

<script type="text/javascript">

    AOS.init({
      easing: 'ease-in-cubic',
      once: true,
      delay: 2600,
    });
  
    jQuery(document).ready(function($) {

      $('a[data-rel^=lightcase]').lightcase({
        swipe: true,
        transition: 'scrollHorizontal',
        speedIn: 300,
        speedOut: 300,
        showSequenceInfo: false,
        fullScreenModeForMobile: true,
        timeout: 6000,
        closeOnOverlayClick: true,
        maxWidth: 1280,
        maxHeight: 960,
      });
      
    });

</script>

@stop

