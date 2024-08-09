@extends('adminlte::page')


@section('content')

    <div id="app">
        <sub-specialization-component></sub-specialization-component>
    </div>


@stop


@section('js')

    <script src="{{ asset('js/app.js') }}"></script>
  
@stop

