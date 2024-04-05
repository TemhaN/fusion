@extends('layout.app')

@section('title', 'Отзывы к фильму: ' . $film->name)

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header border-0 m-2">
        <div class="card-tools">
          <div class="container-input">
            <input id="search" type="text" placeholder="Поиск" name="text" class="input" onkeyup="search()">
            <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
              <path d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z" fill-rule="evenodd"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-4">
            <a href="{{ route('films.edit', $film->id) }}">
                <img src="{{ $film->link_img }}" alt="Film" style="min-height:500px; max-height: 500px; border-radius:25px ">
            </a>
        </div>
        <div class="card-body" style="margin-left: -150px">
            <div class="font-weight-bold film-name d-flex flex-col" style="font-size: 3rem">
                <a href="{{ route('films.edit', $film->id) }}">{{ $film->name }}</a>
                <a class="ml-4" style="margin-top: 15px">
                    <h1 style="background: linear-gradient(to right, #FFD700, #d08801); -webkit-background-clip: text; color: transparent;">
                        {{ $averageRating }}  
                        <i class="fas fa-regular fa-star ml-3" style="background: linear-gradient(to right, #FFD700, #efa620); -webkit-background-clip: text; color: transparent;"></i>
                    </h1>
                </з>
            </div>
            <p class="font-weight-bold mt-5" style="font-size: 1.5rem; color:gray;">О фильме</p>
            <div style="line-height: 20px">
                <div class="row mt-3" style="width: 800px">
                    <div class="col-sm-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-left border-bottom">Страна:</td>
                                <td class="text-right text-muted border-bottom">{{ $film->country->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-left border-bottom">Продолжительность:</td>
                                <td class="text-right text-muted border-bottom">{{ $film->duration }} мин.</td>
                            </tr>
                            <tr>
                                <td class="text-left border-bottom">Дата выхода:</td>
                                <td class="text-right text-muted border-bottom">{{ $film->year_of_issue }}</td>
                            </tr>
                            <tr>
                                <td class="text-left border-bottom">Возраст:</td>
                                <td class="text-right text-muted border-bottom">{{ $film->age }}+</td>
                            </tr>
                            <tr>
                                <td class="text-left border-bottom">Категории:</td>
                                <td class="text-right text-muted border-bottom">
                                    @if($film->categories->isEmpty())
                                        Отсутствуют категории
                                    @else
                                        {{ $film->categories->pluck('name')->implode(', ') }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-end btn-secondary2" style="gap: 30px">
                    <a class="btn btn-secondary button-save" href="{{ $film->link_kinopoisk }}">Ссылка на Кинопоиск</ф>
                        <a class="btn btn-secondary button-save" href="{{ $film->link_video }}">Ссылка на трейлер</a>
                </div>
            </div>
        </div>
    </div>
    <div class="div">
        <p class="font-weight-bold mt-5" style="font-size: 2.5rem; color:black;">Отзывы</p>
    </div>
    <div class="reviews-list">
        @foreach ($reviews as $review)
            @if ($review->user && !$review->user->deleted_at)
                <div class="card mt-4">
                    <div class="card-body">
                        <div>
                            <div class="d-flex">
                                <h5 class="card-title text-muted">{{ $review->user ? $review->user->fio : 'Пользователь не найден' }}</h5>
                                <p class="card-text pl-3"><small class="text-muted">{{ $review->created_at }}</small></p>
                                <a class="ml-5">
                                    <h1 style="background: linear-gradient(to right, #FFD700, #d08801); -webkit-background-clip: text; color: transparent; margin-top: -17px">
                                        @php $userRating = $ratings->where('reviews_id', $review->id)->first();  @endphp
                                        @if ($userRating)
                                        <h5 class="card-title">Оценка: {{ $userRating->ball }}</h5>
                                        <i class="fas fa-regular fa-star ml-3" style="background: linear-gradient(to right, #FFD700, #efa620); -webkit-background-clip: text; color: transparent; margin-top: 12px"></i>
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
                                <span class="badge badge-danger">Не одобрено</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

  </div>
</div>

<style>
.mt-5 a {
    color: inherit;
    text-decoration: none;
}
</style>
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
                return nickname.toLowerCase().includes(q) || messages.some(message => message.toLowerCase().includes(q)) || isApproved.includes(q);
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