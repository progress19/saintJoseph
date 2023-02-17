<?php 

use App\Fun; 

use \MercadoPago\Item;
use \MercadoPago\MerchantOrder;
use \MercadoPago\Payer;
use \MercadoPago\Payment;
use \MercadoPago\Preference;
use \MercadoPago\SDK;

use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Checkout;
use CoinbaseCommerce\Resources\Charge;
use CoinbaseCommerce\Resources\Event;

use App\Reserva;

?>

@extends('layouts.adminLayout.admin_design')
@section('content')

      <div class="col-md-6">
        <div class="x_panel">
          <div class="x_title">
            <h2><i class="fa fa-shopping-cart"></i> Reservas<small>/ Editar</small></h2>
            <ul class="nav navbar-right panel_toolbox">

            @if ($reserva->tipo == 2)
              <span class='badge badge-dark'>Egresados</span>                
            @else
              <span class='badge badge-primary'>Tienda</span>                
            @endif 

            </ul>
            <div class="clearfix"></div>
          </div>

          <div class="x_content">

            {{ Form::open([
              'id' => 'edit_reserva',
              'name' => 'edit_reserva',
              'url' => '/admin/edit-reserva/'.$reserva->id,
              'role' => 'form',
              'method' => 'post',
              'files' => true]) }}

              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('titular', 'Titular') !!}
                  {!! Form::text('titular', $reserva->titular, ['id' => 'titular', 'class' => 'form-control', 'readonly']) !!}
                </div>
              </div>

              <div class="clearfix"></div> 

              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('email', 'Email') !!}
                  {!! Form::text('email', $reserva->email, ['id' => 'email', 'class' => 'form-control', 'readonly']) !!}
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('telefono', 'N° teléfono') !!}
                  {!! Form::text('telefono', $reserva->telefono, ['id' => 'telefono', 'class' => 'form-control', 'readonly']) !!}
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  {!! Form::label('fecha', 'Fecha de actividad') !!}
                  {!! Form::text('fecha', $reserva->fecha, array('class' => 'form-control datespicker','id' => 'fecha','readonly')) !!}      
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  {!! Form::label('turno', 'Turno') !!}
                  {!! Form::text('turno', $reserva->turno, ['id' => 'turno', 'class' => 'form-control', 'readonly']) !!}
                </div>
              </div>

              <div class="clearfix"></div>

              <div class="col-md-12">
                <div class="form-group">
                  {!! Form::label('comentarios', 'Comentarios') !!}
                  {!! Form::textarea('comentarios', $reserva->comentarios, ['id' => 'comentarios', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="clearfix"></div>
              
              <div class="col-md-3">
                <div class="form-group">
                  {!! Form::label('estado', 'Estado') !!}
                  {!! Form::select('estado', array('1' => 'Pagado', '0' => 'Pendiente'), $reserva->estado, ['id' => 'estado', 'class' => 'form-control']); !!}
                </div>
              </div>   

                <div class="col-md-12"><div class="ln_solid"></div>
                <button id="send" type="submit" class="btn btn-success pull-right">Guardar</button>
              </div>

            {!! Form::close() !!}

          </div>
        </div>
      </div>

      <!-- panel paquetes  -->

      <div class="col-md-6">
        <div class="x_panel">
          
          <div class="x_title">
            <h2><i class="fa fa-ticket"></i> Paquetes</h2>
            <ul class="nav navbar-right panel_toolbox"></ul>
            <div class="clearfix"></div>
          </div>

          <div class="x_content">

          <table id="datatabsle-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Paquete</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
              </tr>
            </thead>
            
            <tbody>

            <?php $i = 1; $precio = $total_sin_desc = 0; ?>

            @foreach ($actividades as $actividad)
         
              <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $actividad->nombre }} ({{ $actividad->precio_tipo === 1 ? "Mayor" : "Menor" }}) </td> 
                <td class="right">{{ $actividad->cantidad }}</td>
                <td class="right">${{ number_format($actividad->precio,0, ',', '.') }}</td> 
                <td class="right">${{ number_format($actividad->total,0, ',', '.') }}</td>
              </tr>

            @endforeach

            </tbody>

          </table>

          <div class="totales-edit_reserva">

            <h4>Precio : ${{ number_format($reserva->precio ,0, ',', '.') }}</h4> 
            <h4>Descuento : ${{ number_format($reserva->descuento ,0, ',', '.') }}</h4>
            <h5>Total: ${{ number_format($reserva->total ,0, ',', '.') }}</h4>

          </div>

          <div class="clearfix"></div>

          </div>
        </div>

        <div class="x_panel"> <!-- pago -->
          
          <div class="x_title">
            <h2><i class="fa fa-dollar"></i> Datos del pago</h2>
            <ul class="nav navbar-right panel_toolbox"></ul>

            <div class="clearfix"></div>
          </div>

          <div class="x_content">

            <div class="col-md-9">
          
              
          @if ($reserva->tipoPago == 1)
            <h4>
              <p>Id tx: {{ $reserva->txn_id }}</p>
              <p>Id preferencia: {{ $reserva->preference_id }}</p>
              <p>Estado: {{ $reserva->collection_status }}</p>
              <p>Referencia externa: {{ $reserva->external_reference }}</p>
              <p>Medio: {{ $reserva->payment_type }}</p>
            </h4>
              <?php //$mp = \MercadoPago\SDK::setAccessToken( env('ENV_ACCESS_TOKEN') ); // Either Production or SandBox AccessToken ?>
          @endif    

          @if ($reserva->tipoPago == 2)
            <h4>  
              <p>Id: {{ $reserva->preference_id }}</p>
              <p>Código: <a href="https://commerce.coinbase.com/charges/{{ $reserva->codeCoinbase }}" target="new">{{ $reserva->codeCoinbase }}</a></p>
              <p>Moneda: <img src="{{ Fun::getlogoMoneda($reserva->currency) }}" style="height: 21px;" >  {{ $reserva->currency }} </p>
              <p>Importe: {{ $reserva->amount }}  {{ $reserva->currency }}</p>
              <p>Estado: {!! Reserva::getPagoStatus($reserva->id, $reserva->tipoPago) !!}</p>
            </h4>  
          @endif

            </div>

            <div class="col-md-3">

              @if ($reserva->tipoPago == 1)
                <img src="{{ asset('images/mercado-pago-logo.png') }}" class="img-fluid" alt="">  
              @endif
            
              @if ($reserva->tipoPago == 2)
                <img src="{{ asset('images/coinbase-logo.png') }}" class="img-fluid" alt="">  
              @endif

            </div>

            <div class="col-md-12">
              
 
<?php 
    
  //ApiClient::init("9e598e8f-ae8b-4f49-b3fc-409d56843666");
  //$checkoutObj = Checkout::retrieve($reserva->preference_id);
  
?>

<pre>
 
  
  <?php 

    //$chargeObj = Charge::retrieve($reserva->codeCoinbase);  

     //echo $chargeObj->code.'<br>';

     //echo $chargeObj['payments']['0']['value']['crypto']['amount'] .'<br>';
     //echo $chargeObj['payments']['0']['value']['crypto']['currency'] .'<br>';
     //echo $chargeObj['payments']['0']['status'] .'<br>';

   // print_r($chargeObj);

  ?>

</pre>

<pre>
  
  <?php 

    //print_r($checkoutObj);

  ?>

</pre>



            </div>  

          </div>
        </div>

      </div>

@endsection

@section('page-js-script')

@stop

