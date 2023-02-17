@extends('layouts.adminLayout.admin_design')
@section('content')

<!-- page content -->
<div role="main" style="text-align: center;width: 100%;">
	<img src="{{ asset('images/logo.png') }}" class="img-fluid" width="190px" style="margin-top: 170px" alt="imagen">
</div>
<!-- /page content -->

@endsection

@section('page-js-script')

	@if (session('flash_message'))
		  <script>toast('{!! session('flash_message') !!}');</script>
	@endif

@stop


