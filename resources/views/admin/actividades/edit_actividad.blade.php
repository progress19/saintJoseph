@php
  use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

      <div class="col-md-8">
        <div class="x_panel">
          <div class="x_title">
            <h2><i class="fa fa-ticket"></i> Actividades<small>/ Editar</small></h2>
            <ul class="nav navbar-right panel_toolbox"></ul>
            <div class="clearfix"></div>
          </div>

          <div class="x_content">

            {{ Form::open([
              'id' => 'edit_actividad',
              'name' => 'edit_actividad',
              'url' => '/admin/edit-actividad/'.$actividad->id,
              'role' => 'form',
              'method' => 'post',
              'files' => true]) }}

              <div class="col-md-6">
                <div class="form-group">
                  {!! Form::label('nombre', 'Nombre') !!}
                  {!! Form::text('nombre', $actividad->nombre, ['id' => 'nombre', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="clearfix"></div> 

              <div class="col-md-12">
                <div class="form-group">
                  {!! Form::label('descripcion', 'Descripción') !!}
                  {!! Form::textarea('descripcion', $actividad->descripcion, ['id' => 'descripcion', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="clearfix"></div> 

              <div class="col-md-3">
                <div class="form-group">
                  {!! Form::label('precio_a', 'Precio adulto') !!}
                  {!! Form::number('precio_a', $actividad->precio_a, ['id' => 'precio_a', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  {!! Form::label('precio_b', 'Precio menor') !!}
                  {!! Form::number('precio_b', $actividad->precio_b, ['id' => 'precio_b', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="clearfix"></div> 

              <div class="col-md-3">
                <div class="form-group">
                  {!! Form::label('lugar', 'Lugar') !!}
                  {!! Form::text('lugar', $actividad->lugar, ['id' => 'lugar', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  {!! Form::label('temporada', 'Temporada') !!}
                  {!! Form::text('temporada', $actividad->temporada, ['id' => 'temporada', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  {!! Form::label('dificultad', 'Dificultad') !!}
                  {!! Form::text('dificultad', $actividad->dificultad, ['id' => 'dificultad', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  {!! Form::label('duracion', 'Duración') !!}
                  {!! Form::text('duracion', $actividad->duracion, ['id' => 'duracion', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="clearfix"></div>

              <div class="col-md-3">
                <div class="form-group">
                  {!! Form::label('tipo', 'Tipo') !!}
                  {!! Form::select('tipo', array('1' => 'Común', '2' => 'Destacado'), $actividad->tipo, ['id' => 'tipo', 'class' => 'form-control']); !!}
                </div>
              </div>  

              <div class="col-md-3">
                <div class="form-group">
                  {!! Form::label('orden', 'Orden') !!}
                  {!! Form::number('orden', $actividad->orden, ['id' => 'orden', 'class' => 'form-control']) !!}
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  {!! Form::label('venta', 'Venta (*)') !!}
                  {!! Form::select('venta', array('1' => 'Si', '0' => 'No'), $actividad->venta, ['id' => 'venta', 'class' => 'form-control']); !!}
                </div>
              </div>  

              <div class="clearfix"></div>

       <!-- imgagen -->


        <div class="col-md-3" >
          <div class="form-group">
            {!! Form::label('imagen', 'Imágen') !!}
            {!! Form::file('imagen', null, ['id' => 'imagen', 'class' => 'form-control']) !!}
          </div>
        </div>
        {{ Form::hidden('current_imagen', $actividad->imagen ) }}
        
        <div class="clearfix"></div>

              <div class="col-md-3">
                <div class="form-group">
                  {!! Form::label('estado', 'Estado (**)') !!}
                  {!! Form::select('estado', array('1' => 'Activado', '0' => 'Desactivado'), $actividad->estado, ['id' => 'estado', 'class' => 'form-control']); !!}
                </div>
              </div>   

              <div class="col-md-9" class="pull-right" style="text-align: right;"> 
                <p>* Permite mostrar la Actividad en el sitio con posibilidad o no de reserva.</p>
                <p>** Permite mostrar u ocultar la Actividad.</p>
              </div>

                <div class="col-md-12"><div class="ln_solid"></div>
                <button id="send" type="submit" class="btn btn-success pull-right">Guardar</button>
              </div>

            {!! Form::close() !!}

          </div>
        </div>
      </div>

      <div class="col-md-4">
        
        @if ($actividad->imagen)
          {{ HTML::image(asset(Fun::getPathImage('large','actividad',$actividad->imagen)), 'no-imágen', array('class' => 'img-fluid img_destacada_back', 'style' => '', 'data-toggle' => 'modal', 'data-target' => '#modal_image')) }}
        @endif    
 
      </div>

@endsection

@section('page-js-script')

<script>

  ClassicEditor.create(document.querySelector('#descripcion'))
  .catch(error=> {console.error(error);})
  
</script>

@stop

