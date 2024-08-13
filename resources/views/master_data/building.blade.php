@extends('adminlte::page')


@section('content')

    <div id="app">
        <building-component></building-component>
    </div>


@stop


@section('js')

    <script src="{{ asset('js/app.js') }}"></script>
  
@stop

