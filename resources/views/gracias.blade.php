@extends('layouts.frontLayout.front')
@section('title', 'Reserva')    

@section('content')
@include('_nav-int')

<!-- CONTENT -->
<div class="conte-int" >

    <div class="container">

        <div class="row text-center" style="padding:160px 15px 35px 15px">
            <h2>DATOS DE LA RESERVA</h2>
        </div>

        <div class="row">
           
            <div class="col-sm-12" style="min-height:200px">
                
                {!! $texto !!}   <br> <br>
                
            </div><!-- col -->
        </div><!-- row -->
    </div><!-- container -->

</div><!-- CONTENT -->

@endsection

@section('page-js-script')

@stop

