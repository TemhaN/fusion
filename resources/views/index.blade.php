@extends('layout.app')

@section('title','Главная страница')

@section('content')

<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Статистики</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body d-flex justify-content-between">
                    <div class="d-flex">
                        <h1>{{ $usersCount }}</h1>
                        <p>
                            Пользователей
                        </p>
                    </div>
                    <i class="fas fa-solid fa-user m-2"></i>
                </div>
                <div class="card-footer">
                    <a href="{{ route('users.index') }}" class="small text-white stretched-link">Подробнее</a>
                    <div class="text-white d-flex justify-content-end">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    Фильмы
                </div>
                <div class="card-footer">
                    <a href="{{ route('films.index') }}" class="small text-white stretched-link">Подробнее</a>
                    <div class="text-white d-flex justify-content-end">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    Категории
                </div>
                <div class="card-footer">
                    <a href="{{ route('categories.index') }}" class="small text-white stretched-link">Подробнее</a>
                    <div class="text-white d-flex justify-content-end">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    Страны
                </div>
                <div class="card-footer">
                    <a href="{{ route('countries.index') }}" class="small text-white stretched-link">Подробнее</a>
                    <div class="text-white d-flex justify-content-end">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- <canvas class="webgl"></canvas> --}}

<style>
.layout-footer-fixed .wrapper .main-footer {
    position: fixed;
}
</style>
@endsection
