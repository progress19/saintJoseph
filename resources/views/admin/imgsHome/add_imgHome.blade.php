@extends('layouts.adminLayout.admin_design')
@section('content')

<div class="col-md-10 col-sm-4">
  <div class="x_panel">

    <div class="x_title">
      <h2><i class="fa fa-image"></i> Imágenes Home / <small>Lista</small></h2>
      <div class="clearfix"></div>
    </div>

    <div class="x_content">
                   
      {{ Form::open([
      	'id' => 'add_imgHome',
      	'name' => 'add_imgHome',
      	'url' => '/admin/add-imgHome',
      	'role' => 'form',
      	'method' => 'post',
        'files' => true]) }}
       
          <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('imagen', 'Imagen (1280 x 960)') !!}
              {!! Form::file('imagen', null, ['id' => 'imagen', 'class' => 'form-control']) !!}
            </div>
          </div>

          <div class="clearfix"></div>

          {{--
          <div class="col-md-2">
            <div class="form-group">
              {!! Form::label('estado', 'Estado') !!}
              {!! Form::select('estado', array('1' => 'Activado', '0' => 'Desactivado'), null, ['id' => 'estado', 'class' => 'form-control']); !!}
            </div>
         </div> 
         --}}
          
          <div class="col-md-12"><div class="ln_solid"></div>
              <button id="send" type="submit" class="btn btn-success pull-right">Guardar</button>
          </div>

        {!! Form::close() !!}

    </div>

  </div>
</div>

@endsection

@section('page-js-script')



@stop