@extends('adminlte::page')


@section('content')

    <div id="app">
        <specialization-component></specialization-component>
    </div>


@stop


@section('js')

    <script src="{{ asset('js/app.js') }}"></script>
  
@stop

