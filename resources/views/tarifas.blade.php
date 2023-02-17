<? use App\Fun; ?>

@extends('layouts.frontLayout.front')
@section('title', 'Tarifas')    

@section('content')

  <div id="page-header" style="margin-bottom:0;">  
    <div class="container">
      <div class="row" style="text-align:center">

        <img src="images/tarifas.png" alt=""/>
      </div><!-- col -->

    </div><!-- container -->    
  </div><!-- page-header -->

<div class="container" id="tarifas-container" style="text-align: center;">

    <div class="col-md-12">

     <h3>{!! $config->textoCheckout !!}</h3> 

     <hr>
  
    @if ($config->reservas == 1)
    
      @foreach ($paquetes as $paquete)

      <div class="col-md-4">

        <div class="box-product hvr-grow">

          <div class="box-img">

          {{ HTML::image(asset(Fun::getPathImage('large','paquete',$paquete->imagen)), 'no-imágen', array('class' => 'img-responsive no-desk', 'style' => 'width:100%')) }}

          </div>

          <div class="box-product-title"> {{ $paquete->nombre }} </div>

          <h2>${{ $paquete->precio }}</h2>

          <a href="#0" id="bot_add_{{ $paquete->id }}" data-id="{{ $paquete->id }}" data-precio-actividad="{{ $paquete->precio }}" class="btn btn-default js-cd-add-to-cart {{ Fun::checkEstadoBoton($paquete->id) }}" style="margin-top: 7px;"><i class="fa fa-shopping-cart"></i> {{ Fun::checkTextoBoton($paquete->id) }}</a>
        
        </div>

      </div>

      @endforeach


    @else      

      <h3 style="color: #377700" >{!! $config->textoNoReserva !!}</h3>
      <hr>

      @foreach ($paquetes as $paquete)
      
        <h3>{{ $paquete->nombre }} - ${{ $paquete->precio }}</h3>

        <a href="#0" id="bot_add_{{ $paquete->id }}" data-id="{{ $paquete->id }}" data-precio-actividad="{{ $paquete->precio }}" class="btn btn-default js-cd-add-to-cart disabled" style="margin-top: 7px;"><i class="fa fa-shopping-cart"></i> {{ Fun::checkTextoBoton($paquete->id) }}</a>

      @endforeach

    @endif
   
  </div>     
  </div> 

<div class="clearfix"></div>

<br><br><br>

@include('_carrito')  

@endsection

@section('page-js-script')

@stop

