@extends('layouts.adminLayout.admin_design')
@section('content')

      <div class="col-md-8">
        <div class="x_panel">
          <div class="x_title">
            <h2><i class="fa fa-users"></i> Usuarios<small>/ Editar</small></h2>
            <ul class="nav navbar-right panel_toolbox"></ul>
            <div class="clearfix"></div>
          </div>

          <div class="x_content">

            {{ Form::open([
              'id' => 'add_usuario',
              'name' => 'edit_usuario',
              'url' => '/admin/edit-usuario/'.$usuario->id,
              'role' => 'form',
              'method' => 'post',
              'files' => true]) }}

              <div class="col-md-4">
                <div class="form-group">
                  {!! Form::label('name', 'Nombre') !!}
                  {!! Form::text('name', $usuario->name, ['id' => 'name', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="clearfix"></div>

              <div class="col-md-4">
                <div class="form-group">
                  {!! Form::label('email', 'Email') !!}
                  {!! Form::text('email', $usuario->email, ['id' => 'email', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label for="">Contraseña</label><br>
                    <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#modal_reset">
                     Blanquear contraseña
                    </a>
 
                </div>
              </div>

              <div class="clearfix"></div>

                <div class="col-md-3">
                  <div class="form-group">
                    {!! Form::label('estado', 'Estado') !!}
                    {!! Form::select('estado', array('1' => 'Activado', '0' => 'Desactivado'), $usuario->estado, ['id' => 'estado', 'class' => 'form-control']); !!}
                  </div>
                </div>   

                <div class="col-md-12"><div class="ln_solid"></div>
                <button id="send" type="submit" class="btn btn-success pull-right">Guardar</button>
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


@stop

