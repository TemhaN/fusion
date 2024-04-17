@extends('layout.app')

@section('title','Главная страница')

@section('content')

<div class="card">
  <div class="card-header border-0 m-2">
    <h3 class="card-title">Статистика</h3>
  </div>
</div>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body d-flex flex-row justify-content-between">
                <div class="">
                    <div class="d-flex flex-column align-items-start">
                        <h1>{{ $usersCount }}</h1>
                        <p>
                            Пользователей
                        </p>
                    </div>
                </div>
                <div></div>
                <div class="mb-5 mr-5">
                    <i class="fas fa-solid fa-user" style="font-size: 7rem; position:absolute; opacity:0.3"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('users.index') }}" class="small text-white stretched-link">Подробнее</a>
                <div class="text-white ml-auto p-2">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body d-flex flex-row justify-content-between">
                <div class="">
                    <div class="d-flex flex-column align-items-start">
                        <h1>{{ $filmsCount }}</h1>
                        <p>
                            Фильмов
                        </p>
                    </div>
                </div>
                <div></div>
                <div class="mb-5 mr-5">
                    <i class="fas fa-solid fa-film m-2" style="font-size: 7rem; position:absolute; opacity:0.3"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('films.index') }}" class="small text-white stretched-link">Подробнее</a>
                <div class="text-white ml-auto p-2">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body d-flex flex-row justify-content-between">
                <div class="">
                    <div class="d-flex flex-column align-items-start">
                        <h1>{{ $categoriesCount }}</h1>
                        <p>
                            Категорий
                        </p>
                    </div>
                </div>
                <div></div>
                <div class="mb-5 mr-5">
                    <i class="fas fa-solid fa-icons m-2" style="font-size: 7rem; position:absolute; opacity:0.3"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('categories.index') }}" class="small text-white stretched-link">Подробнее</a>
                <div class="text-white ml-auto p-2">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body d-flex flex-row justify-content-between">
                <div class="">
                    <div class="d-flex flex-column align-items-start">
                        <h1>{{ $countriesCount }}</h1>
                        <p>
                            Стран
                        </p>
                    </div>
                </div>
                <div></div>
                <div class="mb-5 mr-5">
                    <i class="fas fa-solid fa-globe m-2" style="font-size: 7rem; position:absolute; opacity:0.3"></i>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a href="{{ route('countries.index') }}" class="small text-white stretched-link">Подробнее</a>
                <div class="text-white ml-auto p-2">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row d-flex flex-row justify-content-around">
    <div class="col-xl-5 m-2">
        <div class="card mb-4">
            <div class="card-header">
                <p class="chart_cart">Топ категорий</p>
            </div>
            <div class="card-body" style="height: 500px; max-height: 500px;">
                <canvas id="myChart"></canvas>
            </div>
        </div>

    </div>
    <div class="col-xl-5 m-2">
        <div class="card mb-4">
            <div class="card-header">
                <p class="chart_cart">Топ 5 фильмов по оценкам</p>
            </div>
            <div class="card-body" style="height: 500px; max-height: 500px;">
                <canvas id="myCharttwo"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    let categoryNames = @json($categoryNames);
    let categoryFilmCounts = @json($categoryFilmCounts);

    let labels = categoryNames;
    let data = categoryFilmCounts.map(item => item.total);

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Количество фильмов',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

</script>

<script>
    let filmNames = @json($filmNames);

    let topRatedFilms = @json($topRatedFilms);
    let topRatedFilmsArray = Object.values(topRatedFilms);

    let labelstwo = filmNames;
    let datatwo = topRatedFilmsArray.map(item => item.average_rating);

    var ctx = document.getElementById('myCharttwo').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelstwo,
            datasets: [{
                label: 'Оценка фильма',
                data: datatwo,
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: true
            }]
        },
        options: {

        maintainAspectRatio: false
        }});
</script>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card mb-4">
                <div class="card-header text-center">
                    <p class="chart_cart">Телек глянь</p>
                </div>
                <div class="card-body card_web">
                    <canvas class="webgl"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .webgl, #loader {
        position: relative!important;
        width: 100%!important;
        height: 100%!important;
        margin-top: 0!important;
        background-color: #FAEDCD;
    }
    .card_web {
        background-color: #FAEDCD
    }
    .layout-footer-fixed .wrapper .main-footer {
        position: fixed;
    }
</style>

@endsection
