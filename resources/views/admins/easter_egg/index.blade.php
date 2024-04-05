@extends('layout.app')

@section('title','Easter Egg')

@section('content')

  <div class="div-background">
      <canvas id="canvas"></canvas>
  </div>

<style>
    .div-background {
        margin-top: 5%;
        background: black;
        z-index: 1;
        top: 0;
        display: block;
        position: fixed;
    }
    canvas {

    }
    .dg.ac {
        z-index: 2;
        margin-top: 5%;
        position: absolute;
    }
    .layout-footer-fixed .wrapper .main-footer {
        position: fixed;
    } 

</style>
@endsection
