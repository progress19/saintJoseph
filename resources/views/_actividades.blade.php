<? use App\Fun; ?>
<section id="actividades">

    <div class="title-galeria">RESERVÁ TUS ACTIVIDADES Y RECIBÍ IMPORTANTES DESCUENTOS!!! </div><br><br>

    <div class="container">
        <h3 class="text-center text-white">Reservando cualquier actividad, tenés acceso libre a nuestro complejo de piscinas!!!</h3><br><br>
    </div>

    @isset ($actividades)

        <div class="container">
            
            <div class="row">

                @foreach ($actividades as $actividad)
                  
                    <div class="col-md-6 col-sm-12">

                        <div class="box-actividad" data-aos="flip-up" >

                            <div class="row g-0">
                                <div class="col">
                                    <h2>{{ $actividad->nombre }}</h2>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="row g-0">

                                    <div class="col-md-5">
                                        <img src="{{ asset('pics/actividad/large/'.$actividad->imagen) }}" class="img-fluid" alt="">                                
                                    </div>
                                    
                                    <div class="col-md-7 px-3 detalle-actividad">
                                     
                                        <div style="text-align: justify;">{!! $actividad->descripcion !!}</div> 

                                        <hr>

                                        <div class="row g-0">

                                            <div class="col">
                                                <i class="fa-solid fa-location-dot fa-fw"></i> {{ $actividad->lugar }}.
                                            </div>

                                            <div class="col">
                                                <i class="fa-regular fa-calendar-days fa-fw"></i> {{ $actividad->temporada }}.
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col">
                                                <i class="fa-solid fa-turn-up fa-fw"></i> Dificultad: {{ $actividad->dificultad }}.
                                            </div>

                                            <div class="col">
                                                <i class="fa-regular fa-clock fa-fw"></i> Duración: {{ $actividad->duracion }}.
                                            </div>

                                        </div>
                          
                                    </div>

                                </div>

                                <div class="clearfix"></div>

                                <div class="precio-actividad">    
                                                        
                                    <div class="row g-0 text-center">
                                        
                                        <div class="col">
                                            <h3>Adulto: ${{ number_format($actividad->precio_a,0, ',', '.') }}<br>
                                               <a href="#0" id="" data-id="{{ $actividad->id }}" data-precio="1" data-precio-actividad="{{ $actividad->precio_a }}" class="bot_add_{{ $actividad->id }}1 btn btn-default js-cd-add-to-cart {{ Fun::checkEstadoBoton($actividad->id.'1') }}" ><i class="fa fa-shopping-cart"></i> {{ Fun::checkTextoBoton($actividad->id.'1') }}
                                               </a>
                                            </h3>
                                        </div>

                                        <div class="col">
                                            <h3>Menor: ${{ number_format($actividad->precio_b,0, ',', '.') }}<br>
                                                <a href="#0" id="" data-id="{{ $actividad->id }}" data-precio="2" data-precio-actividad="{{ $actividad->precio_b }}" class="bot_add_{{ $actividad->id }}2 btn btn-default js-cd-add-to-cart {{ Fun::checkEstadoBoton($actividad->id.'2') }}"><i class="fa fa-shopping-cart"></i> {{ Fun::checkTextoBoton($actividad->id.'2') }}
                                                </a>
                                            </h3>
                                        </div>

                                    </div> <!-- row -->
                          
                                </div>

                            </div>                        

                    </div>
                    
                @endforeach

            </div>
        
        </div>
            
    @endisset
    
</section>