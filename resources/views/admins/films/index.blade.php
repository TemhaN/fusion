@extends('layout.app')

@section('title', 'Фильмы')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="mb-3">
        <a href="{{ route('films.create') }}" class="btn btn-success button-savet">Добавить</a>
      </div>
      <div class="card">
        <div class="card-header border-0 m-2">
          <h3 class="card-title">Таблица Фильмов</h3>

          <div class="card-tools">
            <div class="container-input">
              <input id="search" type="text" placeholder="Поиск" name="text" class="input" onkeyup="search()">
              <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z"
                  fill-rule="evenodd"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container" style="width: 70%; max-width: 70%;">
      <div class="row mt-3">
        @foreach ($films as $film)
          <div class="col-sm film mt-2">
            <div class="card card-film" style="width: 17rem; min-height:670px; max-height: 670px; max-width:100%;">
              <div class="card-head">
                <div class="overlay" style="background-image: url('{{ $film->link_img }}');"></div>
                <a href="{{ route('filminfo.show', $film->id) }}">
                  <div class="card-image-container">
                    <img src="{{ $film->link_img }}" alt="Film" class="card-img-top rounded mr-3 card-image"
                      style="object-fit: cover;">
                  </div>
                </a>
              </div>
              <div class="card-body">
                <h3 class="dropdown-item-title">
                  <div class="d-flex flex-col w-auto">
                    <a href="{{ route('filminfo.show', $film->id) }}">{{ $film->name }}</a>
                    <p class="ml-2">{{ $film->age }}+</p>
                  </div>
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Дата выхода: {{ $film->year_of_issue }}</p>
                <p class="text-sm">Продолжительность: {{ $film->duration }} мин.</p>
              </div>
              <div class="card-footer d-flex flex-row align-items-end mt-auto justify-content-end">
                <a href="{{ route('films.edit', $film->id) }}" class="btn btn-success button-save mx-auto">Изменить</a>
                <form action="{{ route('films.destroy', $film->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger button-close">Удалить</button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <script>
    window.onload = function() {
      let cards = document.querySelectorAll(".card");
      cards.forEach(function(card) {
        card.addEventListener("mouseover", function() {
          this.querySelector(".card-img-top").style.transform = "scale(1.1)";
          this.querySelector(".overlay").style.opacity = "0.85";
          this.querySelector(".overlay").style.transform = "scale(1.1)";
          this.querySelector(".card-image-container").style.zIndex = "50";
        });
        card.addEventListener("mouseout", function() {
          this.querySelector(".card-img-top").style.transform = "scale(1)";
          this.querySelector(".overlay").style.opacity = "0";
          this.querySelector(".overlay").style.transform = "scale(0.8)";
        });
      });
      let search = document.getElementById('search');
      search.addEventListener('keyup', function() {
        let query = search.value.toLowerCase();
        let queries = query.split(' ');
        let movies = document.querySelectorAll('.film');

        for (let i = 0; i < movies.length; i++) {
          let movie = movies[i];
          let name = movie.querySelector('h3').textContent;
          let genre = movie.querySelector('p').textContent;

          let match = queries.every(function(q) {
            return name.toLowerCase().includes(q) || genre.toLowerCase().includes(q);
          });

          if (!match) {
            movie.style.display = 'none';
          } else {
            movie.style.display = 'block';
          }
        }
      });
    };
  </script>

  <style>
    .card-image-container {
      position: relative;
      overflow: hidden;
      border-radius: 25px;
    }

    .overlay {
      overflow: visible;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 57.5%;
      background-size: cover;
      background-position: center;
      filter: blur(23px);
      transform: scale(0.8);
      opacity: 0;
      border-radius: 25px;
      transition: opacity 0.4s ease, transform 0.5s ease;
    }


    .card-image {
      z-index: 2;
      border-radius: 25px;
      transition: transform 0.4s ease;
    }
  </style>

@endsection
