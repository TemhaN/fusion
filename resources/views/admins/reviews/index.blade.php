@extends('layout.app')

@section('title','Список Отзывов')

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
    <div class="container">
        <h1>Список Отзывов</h1>
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
                                        @php $userRating = $ratings->where('user_id', $review->user_id)->first(); @endphp
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
