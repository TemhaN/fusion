@extends('layout.app')

@section('title', 'Список Актёров')

@section('content')

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Добавить актёра</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="font-size: 2.5rem; color: #333333;">&times;</span>
          </button>
        </div>
        <form action="{{ isset($actor) ? route('actors.update', $actor->id) : route('actors.store') }}" method="POST">
          @isset($actor)
            @method('PATCH')
          @endisset
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="name">ФИО</label>
              <input type="text" class="@error('name') is-invalid @enderror form-control" id="name" name="name"
                value="{{ old('name', isset($actor) ? $actor->name : '') }}">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
              <label for="img_link">Аватар (Ссылка)</label>
              <input type="img_link" class="form-control" id="img_link" name="img_link"
                value="{{ old('img_link', isset($actor) ? $actor->img_link : '') }}">
              @error('img_link')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success button-save">Сохранить</button>
            <button type="button" class="btn btn-danger button-save" data-dismiss="modal">Закрыть</button>
          </div>
        </form>
      </div>
    </div>
  </div>



  <div class="row">
    <div class="col-12">
      <div class="mb-3">
        <a href="{{ route('actors.create') }}" class="btn btn-success button-savet" data-toggle="modal"
          data-target="#exampleModal">Добавить</a>
      </div>
      <div class="card">
        <div class="card-header border-0 m-2">
          <h3 class="card-title">Таблица Актёров</h3>
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
        <div class="table-responsive p-0">
          <table class="table table-hover text-nowrap table-borderless table-striped">
            <thead>
              <tr>
                <th>ФИО</th>
                <th style="width: 5%"></th>
              </tr>
            </thead>
            <tbody class="actors-list">
              @foreach ($actors as $actor)
                <tr>
                  <th><a href="#" data-toggle="modal"
                      data-target="#myModal{{ $actor->id }}">{{ $actor->name }}</a>
                    <div class="modal fade" id="myModal{{ $actor->id }}">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Редактировать Актёра</h4>
                            <button type="button" class="close" data-dismiss="modal"
                              style="font-size: 2.5rem; color: #333333;">&times;</button>
                          </div>
                          <div class="modal-body">
                            <form action="{{ route('actors.update', $actor->id) }}" method="POST">
                              @csrf
                              @method('PATCH')
                              <div class="form-group">
                                <label for="name">ФИО</label>
                                <input type="text" class="@error('name') is-invalid @enderror form-control"
                                  id="name" name="name"
                                  value="{{ old('name', isset($actor) ? $actor->name : '') }}">
                                @error('name')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                @enderror
                                <label for="img_link">Аватар (Ссылка)</label>
                                <input type="img_link" class="form-control" id="img_link" name="img_link"
                                  value="{{ old('img_link', isset($actor) ? $actor->img_link : '') }}">
                                @error('img_link')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                @enderror
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-success button-save">Сохранить</button>
                            <button type="button" class="btn btn-danger button-close"
                              data-dismiss="modal">Закрыть</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </th>
                  <th>
                    <form action="{{ route('actors.destroy', $actor->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger button-close">Удалить</button>
                    </form>
                  </th>
              @endforeach
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script>
    window.onload = function() {
      let search = document.getElementById('search');
      search.addEventListener('keyup', function() {
        let query = search.value.toLowerCase();
        let actors = document.querySelectorAll('.actors-list tr');

        for (let i = 0; i < actors.length; i++) {
          let country = actors[i];
          let name = country.querySelector('th a').textContent;

          if (!name.toLowerCase().includes(query)) {
            country.style.display = 'none';
          } else {
            country.style.display = '';
          }
        }
      });
    };
  </script>
@endsection
