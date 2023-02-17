<? use App\Fun; ?>
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    <link href="http://www.pixtudios.net/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <table cellspacing="0" cellpadding="10" style="color:#666;font:15px Arial;line-height:1.4em;width:100%;">
        <tbody>
            <tr>
                <td style="color:#333;font-size:15px;padding-top:18px;">

                    <div class="container">

                        <div class="row clearfix">
                            <div class="col-md-12 column">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <div style="padding:15px">
                                                <img src="https://saintjosephweb.com.ar/images/logo.png" style="width:150px" >   
                                            </div>
                                        </h3>
                                    </div>

                                    <div class="panel-body" style="color: #333; font-size: 15px;">

                                        <p>{!! $textoEmail !!}</p>

                                        <h3>N° de Reserva : <strong> {{ $reserva['id'] }} </strong></h3>
                                        <hr>

                                        <b>Fecha de la Actividad : </b>{{ $reserva['fecha'] }}<br> 
                                        <b>Nombre y Apellido: </b>{{ $reserva['titular'] }}<br> 
                                        <b>Email : </b>{{ $reserva['email'] }}<br> 
                                        <b>Teléfono : </b>{{ $reserva['telefono'] }}<br> 
                                        <b>Comentarios : </b>{{ $reserva['comentarios'] }}<br>

                                        <hr>

                                        <p><b>Detalle de actividades</b></p>

                                        {!! $actividades !!}

                                        <p>{!! $totales !!}</p>

                                        <hr>

                                            <p><b>Datos MercadoPago</b></p>

                                            <p>N° de transacción: {{ $reserva->txn_id }}</p>
                                            <p>Estado : {{ $reserva->collection_status }}</p><br>

                                    </div>

                                    <hr>

                                    <div class="panel-footer">

                                        <strong>SAINT JOSEPH TURISMO AVENTURA</strong><br>
                                        Ruta Provincial 173 KM 28.5<br>
                                        San Rafael - Mendoza <br>
                                        Teléfono: (0260) 467-3443<br>
                                        <a href="mailto:info@saintjosephweb.com.ar" style="color: #3f3f3f;">info@saintjosephweb.com.ar</a> / <a href="https://saintjosephweb.com.ar" style="color: #3f3f3f;">saintjosephweb.com.ar</a><br>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                </td>
            </tr>
            <tr>
                <td style="padding:15px 20px;text-align:left;padding-top:5px;border-top:solid 1px #dfdfdf">
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>