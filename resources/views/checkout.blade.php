<?
    use App\Fun;
    $cant = 1;
    $total_total = 0;
?>

@extends('layouts.frontLayout.front')
@section('title', 'Saint Joseph Turismo Aventura - Checkout')
@include('_nav-int')     

@section('content')
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="conte-int">

    <div class="container">

        <div class="row text-center" style="padding:160px 15px 35px 15px">
            <h2>CHECKOUT</h2>
        </div>
        
        <div class="row">

            <div class="col-md-6 resumen" id="colForm">

                <div id="mensaje" style="display: none; text-align: center;margin-bottom: 20px;"></div>

                {{ Form::open(array('id' => 'frmReserva', 'role' => 'form')) }}

                <div class="panel-checkout">
                    <h4>- Por favor, completá el siguiente formulario para continuar con el proceso de reserva.</h4>    <hr>

                    <div class="row">

                        <div class="col-md-5">
                            <div class="form-group mb-3">
                                {!! Form::label('fecha', 'Fecha de actividad') !!}
                                {!! Form::text('fecha', null, array('class' => 'form-control datespicker','id' => 'fecha', )) !!}      
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                {!! Form::label('nombre', 'Nombre y Apellido') !!}
                                {!! Form::text('nombre', null, ['id' => 'nombreForm', 'class' => 'form-control']) !!}

                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                {!! Form::label('email', 'E-mail') !!}
                                {!! Form::email('email', null, ['id' => 'emailForm', 'class' => 'form-control']) !!}

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                {!! Form::label('telefono', 'Teléfono / Móvil') !!}
                                {!! Form::text('telefono', null, ['id' => 'telefonoForm', 'class' => 'form-control']) !!}

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                {!! Form::label('comentario', 'Comentario') !!}
                                {!! Form::textarea('comentario', null, ['id' => 'comentarioForm', 'class' => 'form-control', 'rows' => 5, 'cols' => 40]) !!}
                            </div>
                        </div>

                    </div> <!-- fin row -->

                    <input id="opcionPago" name="opcionPago" type="text" class="displayNone">
                    <input type="text" class="displayNone" id="checkoutId" name="checkoutId" value="<?php echo $checkoutObj->id; ?>" >
                    <input type="text" class="displayNone" id="external_reference" name="external_reference" value="<?php echo $external_reference; ?>" >

                    {{ Form::hidden('baseUrl', url('/'), array('id' => 'baseUrl')) }}

                </div>

            </div>

            {!! Form::close() !!}

            <div class="col-md-6 resumen" id="colResumen" >

                <div class="panel-checkout">

                    <h4>- RESUMEN</h4>
                    <hr>    

                    @if ( session()->has('cart') )

                    @foreach ( session()->get('cart') as $actividad )

                    <li>

                        <div class="ckeckout_nombre">
                            #{{ $cant++ }} - {{ $actividad["nombre"] }} ({{ $actividad["precio_tipo"] === "1" ? "Mayor" : "Menor" }}) 
                        </div>

                        <div class="checkout_cantidad">{{  $actividad["cantidad"] }}</div>
                        <div class="checkout_unitario">$ {{ $actividad["precio"] }}</div>
                        <div class="checkout_total" >${{ $actividad["precio"] * $actividad["cantidad"] }}</div> 

                    </li> 

                    <hr>

                    <?php $total_total = $total_total + ($actividad["precio"] * $actividad["cantidad"]); ?>

                    @endforeach

                    @endif

                    <div class="checkout_total_total">

                        @if ($total_descuento > 0)

                        <h5>Total: <b style="text-decoration: line-through">$<?php echo number_format($total_total,2, ',', '.'); ?></b></h5> 
                        <h4>Descuento: <b>$<?php echo number_format($total_descuento,2, ',', '.'); ?></b></h4> 
                        <hr>

                        @endif

                        <h3>TOTAL A PAGAR: <b>$<?php echo number_format($total_a_pagar,0, ',', '.'); ?>.-</b></h3>

                    </div>

                    <hr>

                    <div id="conteOpcionesPago">

                        <h4>SELECCIONÁ LA FORMA DE PAGO:</h4>
                        <hr>
                        <a onclick="clicOpcionPago(1)" class="pxay-checkout">

                            <div class="col-md-12" style="text-align: center;">
                                <img src="{{ url('images/mercado-pago-logo.png') }}" class="img-responsive logo-mp-checkout hvr-bounce-in" alt="">
                            </div>

                            <div class="clearfix"></div>

                        </a>


                        <div class="clearfix"></div>

                        <br>

                    </div> <!-- conteOpcionesPago -->


                    <div id="loadingOpcionesPago" style="display: none;"></div>

                    <div class="clearfix"></div>

                </div>

                <div class="aclaraciones" role="alert">
                    <strong>Aclaraciones :</strong> <br>

                    {!! $textoCheckout !!} 

                </div>

            </div>
        </div> <!-- row -->
    </div> <!-- container -->

</div>

@endsection

@section('page-js-script')

<!-- bootstrap-datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js" integrity="sha512-5pjEAV8mgR98bRTcqwZ3An0MYSOleV04mwwYj2yw+7PBhFVf/0KcE+NEox0XrFiU5+x5t5qidmo5MgBkDD9hEw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    $('.datespicker').datepicker({
        format: "d-m-yyyy",
        //todayBtn: "linked",
        autoclose: true,
        //todayHighlight: true,
        //endDate: '+7d',
        startDate: '1d',
        language: "es",
    });

</script>

<script src="https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js" data-preference-id="{{ $preferenceId }}">bos</script>

@stop

