@extends('adminlte::page')


@section('content')

    <div id="app">
        <doctor-specialization-component></doctor-specialization-component>
    </div>


@stop


@section('js')

    <script src="{{ asset('js/app.js') }}"></script>
  
@stop

