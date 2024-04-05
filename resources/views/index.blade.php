@extends('layout.app')

@section('title','Главная страница')

@section('content')

<canvas id="canvas" class="webgl"></canvas>
<div id="loader">
    <h1>Loading...</h1>
</div>

<style>
.layout-footer-fixed .wrapper .main-footer {
    position: fixed;
} 

</style>
@endsection