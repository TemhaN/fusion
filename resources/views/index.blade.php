@extends('layout.app')

@section('title', 'Главная страница')

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
  <div class="row">
    <div class="col-xl-6 col-md-6">
      <div class="card bg-info text-white mb-4">
        <div class="card-body d-flex flex-row justify-content-between">
          <div class="">
            <div class="d-flex flex-column align-items-start">
              <h1>{{ $ratingsCount }}</h1>
              <p>
                Оценок
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
    <div class="col-xl-6 col-md-6">
      <div class="card bg-dark text-white mb-4">
        <div class="card-body d-flex flex-row justify-content-between">
          <div class="">
            <div class="d-flex flex-column align-items-start">
              <h1>{{ $actorsCount }}</h1>
              <p>
                Актёров
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
      }
    });
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
    .webgl,
    #loader {
      position: relative !important;
      width: 100% !important;
      height: 100% !important;
      margin-top: 0 !important;
      background-color: #FAEDCD;
    }

    .card_web {
      background-color: #FAEDCD
    }

    .layout-footer-fixed .wrapper .main-footer {
      position: fixed;
    }
  </style>


  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header border-0 m-2">
          <h3 class="card-title">Отзывы на рассмотрении</h3>

          <div class="card-tools">
            <div class="container-input">
              <input id="search" type="text" placeholder="Поиск" name="text" class="input"
                onkeyup="search()">
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
      <div class="container">
        <h1>Список Отзывов</h1>
        <div class="reviews-list">
          @foreach ($reviews as $review)
            @if ($review->user && !$review->user->deleted_at)
              <div class="card mt-4">
                <div class="card-body">
                  <div>
                    <div class="d-flex">
                      <h5 class="card-title text-muted">
                        {{ $review->user ? $review->user->fio : 'Пользователь не найден' }}</h5>
                      <p class="card-text pl-3"><small class="text-muted">{{ $review->created_at }}</small></p>
                      <a class="ml-5">
                        <h1
                          style="background: linear-gradient(to right, #FFD700, #d08801); -webkit-background-clip: text; color: transparent; margin-top: -17px">
                          @php $userRating = $ratings->where('user_id', $review->user_id)->first(); @endphp
                          @if ($userRating)
                            <h5 class="card-title">Оценка: {{ $userRating->ball }}</h5>
                            <i class="fas fa-regular fa-star ml-3"
                              style="background: linear-gradient(to right, #FFD700, #efa620); -webkit-background-clip: text; color: transparent; margin-top: 12px"></i>
                          @endif
                        </h1>
                      </a>
                    </div>
                    <div class="d-flex justify-content-end">
                      <form action="{{ route('admins.users.ban', $review->user_id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-danger button-close">Забанить</button>
                      </form>
                    </div>
                  </div>
                  <p class="card-text mb-4">{{ $review->message }}</p>
                  <div class="d-flex" style="gap: 30px">
                    <form action="{{ route('reviews.toggle', $review->id) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      @if ($review->is_approved)
                        <button type="submit" class="btn btn-warning button-save">Снять одобрение</button>
                      @else
                        <button type="submit" class="btn btn-success button-save">Одобрить</button>
                      @endif
                    </form>
                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger button-close">Удалить отзыв</button>
                    </form>
                  </div>
                  <div class="d-flex flex-row justify-content-end">
                    @if ($review->is_approved)
                      <span class="badge badge-success">Одобрено</span>
                    @else
                      <span class="badge badge-danger">На рассмотрении</span>
                    @endif
                  </div>
                </div>
              </div>
            @endif
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <script>
    window.onload = function() {
      let search = document.getElementById('search');
      search.addEventListener('keyup', function() {
        let query = search.value.toLowerCase();
        let queries = query.split(' ');
        let reviews = document.querySelectorAll('.reviews-list .card');

        for (let i = 0; i < reviews.length; i++) {
          let review = reviews[i];
          let nickname = review.querySelector('.card-title').textContent;
          let messages = Array.from(review.querySelectorAll('.card-text')).map(el => el.textContent);
          let isApproved = review.querySelector('.badge').textContent.toLowerCase();

          let match = queries.every(function(q) {
            return nickname.toLowerCase().includes(q) || messages.some(message => message.toLowerCase()
              .includes(q)) || isApproved.includes(q);
          });

          if (!match) {
            review.style.display = 'none';
          } else {
            review.style.display = '';
          }
        }
      });
    };
  </script>
@endsection
