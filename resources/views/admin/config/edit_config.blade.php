@extends('layouts.adminLayout.admin_design')
@section('content')

<div class="col-md-8">
  <div class="x_panel">
    <div class="x_title">
      <h2><i class="far fa-file-alt"></i> Configuración<small> / Editar</small></h2>
      <ul class="nav navbar-right panel_toolbox"></ul>
      <div class="clearfix"></div>
    </div>

    <div class="x_content">

      {{ Form::open([
        'id' => 'edit_config',
        'name' => 'edit_config',
        'url' => '/admin/edit-config/'.$config->id,
        'role' => 'form',
        'method' => 'post',
        'files' => true]) }}

        <div class="row">

          <div class="col-md-12">
            <div class="form-group">
              {!! Form::label('destinatarios', 'Destinatarios formularios (separados por coma, ej : info@saintjosephweb.com.ar,consultas@saintjosephweb.com.ar)') !!}
              {!! Form::text('destinatarios', $config->destinatarios, ['id' => 'destinatarios', 'class' => 'form-control']) !!}
            </div>
          </div>  

<br><br>

        <div class="x_content">

          <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Tienda</a>
            </li>
          </ul>

          <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

              <div class="col-md-12">
                <div class="form-group">
                  {!! Form::label('textoCheckout', 'Texto Checkout') !!}
                  {!! Form::textarea('textoCheckout', $config->textoCheckout, ['id' => 'textoCheckout', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="clearfix"></div>

              <div class="col-md-12">
                <div class="form-group">
                  {!! Form::label('textoEmail', 'Texto email reserva') !!}
                  {!! Form::textarea('textoEmail', $config->textoEmail, ['id' => 'textoEmail', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="clearfix"></div>

              <div class="col-md-12">
                <div class="form-group">
                  {!! Form::label('textoNoReserva', 'Texto reservas suspendidas') !!}
                  {!! Form::textarea('textoNoReserva', $config->textoNoReserva, ['id' => 'textoNoReserva', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="clearfix"></div>

              <div class="col-md-3">
                <div class="form-group">
                  {!! Form::label('reservas', 'Reservas') !!}
                  {!! Form::select('reservas', array('1' => 'Activadas', '0' => 'Suspendidas'), $config->reservas, ['id' => 'reservas', 'class' => 'form-control']); !!}
                </div>
              </div>  

            </div>

          </div>

        </div>

          <div class="clearfix"></div>

          <div class="col-md-12"><div class="ln_solid"></div>
          <button id="send" type="submit" class="btn btn-success pull-right">Guardar</button>

        </div>

      </div>

      {!! Form::close() !!}

    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modal_reset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Blanquear contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div class="col-md-6">
          <div class="form-group">
            <label for="">Nueva contraseña</label>
            <input type="password" id="newPassword" class="form-control">

          </div>
        </div>      

        <input type="hidden" id="userID" value="1" > <!-- The value is the id of the user whose password is about to be reset -->

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" id="reset_pwd" class="btn btn-info">Guardar</button>
      </div>
    </div>
  </div>
</div>


@endsection

@section('page-js-script')

<script>

  ClassicEditor.create(document.querySelector('#textoCheckout'))
  .catch(error=> {console.error(error);})

  ClassicEditor.create(document.querySelector('#textoEmail'))
  .catch(error=> {console.error(error);})

  ClassicEditor.create(document.querySelector('#textoNoReserva'))
  .catch(error=> {console.error(error);})

  ClassicEditor.create(document.querySelector('#textoCheckoutE'))
  .catch(error=> {console.error(error);})

  ClassicEditor.create(document.querySelector('#textoEmailE'))
  .catch(error=> {console.error(error);})

  ClassicEditor.create(document.querySelector('#textoNoReservaE'))
  .catch(error=> {console.error(error);})

</script>

@stop

















