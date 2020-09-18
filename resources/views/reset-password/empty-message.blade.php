
@extends('layouts.master')

@section('content-header')
@stop

@section('content')
	<h3 class="text-center">{{ isset($message)?$message:'' }}</h3>
@stop

@section('footer')
@stop
@section('shortcuts')
@stop

@push('js-stack')
@endpush