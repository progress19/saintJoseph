@extends('layouts.adminLayout.admin_design')
@section('content')

<!-- page content -->
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="row">
              <div class="col-md-9 col-sm-9 col-xs-9">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="far fa-image"></i> Imágenes Home<small> / Editar imagen</small></h2>
                    <ul class="nav navbar-right panel_toolbox"></ul>
                    <div class="clearfix"></div>
                  </div>
                  
                  <div class="x_content">
                   
  {{ Form::open([
  	'id' => 'edit_imgHome',
  	'name' => 'edit_imgHome',
  	'url' => '/admin/edit-imgHome/'.$imagen->id,
  	'role' => 'form',
  	'method' => 'post',
    'files' => true]) }}

    <div class="row">

      <div class="col-md-6">
        <div class="form-group">
          {!! Form::label('imagen', 'Imagen (610 x 232 png)') !!}
          {!! Form::file('imagen', null, ['id' => 'imagen', 'class' => 'form-control']) !!}
        </div>
      </div>
      {{ Form::hidden('current_imagen', $imagen->imagen ) }}
    
      <div class="clearfix"></div>

      <div class="col-md-3">
        <div class="form-group">
    			{!! Form::label('url', 'Url (incluir https://)') !!}
    			{!! Form::text('url', $imagen->url, ['id' => 'url', 'class' => 'form-control']) !!}
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-group">
          {!! Form::label('idioma', 'Idioma') !!}
          {!! Form::select('idioma', array('1' => 'Español', '2' => 'Ingles'), $imagen->idioma, ['id' => 'idioma', 'class' => 'form-control']); !!}
        </div>
     </div> 

      <div class="clearfix"></div>

      <div class="col-md-3">
        <div class="form-group">
          {!! Form::label('estado', 'Estado') !!}
          {!! Form::select('estado', array('1' => 'Activado', '0' => 'Desactivado'), $imagen->estado, ['id' => 'estado', 'class' => 'form-control']); !!}
        </div>
     </div>   
          
      <div class="col-md-12"><div class="ln_solid"></div>
          <button id="send" type="submit" class="btn btn-success pull-right">Guardar</button>
      </div>

    </div>

    {!! Form::close() !!}

                  </div>
                </div>
              </div>

              <div class="col-md-3 col-sm-3 col-xs-3">
                <div class="x_panel">
                  @if ($imagen->imagen)
                   {{ HTML::image(asset('pics/imgsHome/large/'.$imagen->imagen),null,['class'=>'img-responsive'] ) }}
                  @endif
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- /page content -->
<!-- /page content -->
</div>

@endsection

@section('page-js-script')

@stop