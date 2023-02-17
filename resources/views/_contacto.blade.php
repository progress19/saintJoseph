<section id="contacto">
  
    <div class="container">

        <div class="col-md-12 text-center titulo">
            <h1>CONTACTO</h1>
        </div>

        <div class="row">

            <div class="col-md-4 col-sm-12 left-contacto">

                <div id="responseContacto"></div>

                <form method="POST" id="frmContacto">

                    <div class="mb-3 mt-3">
                        <input type="text" class="form-control" id="nombre_f" name="nombre" placeholder="NOMBRE">
                    </div>

                    <div class="mb-3 mt-3">
                        <input type="text" class="form-control" id="apellido_f" name="apellido" placeholder="APELLIDO">
                    </div>

                    <div class="mb-3 mt-3">
                        <input type="text" class="form-control" id="whatsapp_f" name="whatsapp" placeholder="WHATSAPP">
                    </div>

                    <div class="mb-3 mt-3">
                        <input type="email" class="form-control" id="email_f" name="email" placeholder="EMAIL">
                    </div>

                    <div class="mb-3">
                        <textarea class="form-control" id="comentario_f" name="comentario" rows="3" placeholder="COMENTARIO"></textarea>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3 float-end">ENVIAR</button>
                    </div>

                    <input type="hidden" id="baseUrl" value="{{ url('/') }}" >
                                    
                </form>    

            </div>

            <!-- center -->

            <div class="col-md-4 col-sm-12">
                <div id="google-map2" style="position: relative; overflow: hidden;width: 100%;min-height: 386px"></div>
            </div>


            <!-- right -->

            <div class="col-md-4 col-sm-12 info-contacto">
                <h4>UBICACIÓN</h4>
                <p>Ruta Provincial 173 KM 28.5</p>
                <p>San Rafael - Mendoza</p>

                <h4 class="mt-4">HORARIOS DE ATENCIÓN</h4>
                <p>Todos los días de 10 a 19hs</p>

                <h4 class="mt-4">CONSULTAS</h4>
                <p><a href="tel:02604673443"></a>TEL: (0260) 467-3443</p>
                <p><a href="https://api.whatsapp.com/send?phone=542604673443">Whatsapp: (0260) 467-3443</a></p> 
                <p><a href="mailto:info@saintjosephweb.com.ar">info@saintjosephweb.com.ar</a></p>
                <a href="https://www.facebook.com/saintjosephturismoaventura" style="font-size: 38px;" target="new"><i class="fa-brands fa-square-facebook"></i></a>
             </div>

        </div>
    
    </div>

</section>

