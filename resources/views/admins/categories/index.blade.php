@extends('layout.app')

@section('title', 'Категории фильмов')

@section('content')

  <div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog" aria-labelledby="createCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createCategoryModalLabel">Создать категорию</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="font-size: 2.5rem; color: #333333;">&times;</span>
          </button>
        </div>
        <form action="{{ route('categories.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Название</label>
              <input type="text" class="@error('name') is-invalid @enderror form-control" id="name" name="name"
                value="{{ old('name') }}">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
            <div style="col-md-6">
              <div class="form-group">
                <label>Родительский жанр</label>
                <select class="form-control select2" style="width: 100%;" name="parent_id">
                  <option value="">Нет родительского жанра</option>
                  @foreach ($categories as $parentCategory)
                    <option value="{{ $parentCategory->id }}">
                      {{ $parentCategory->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success button-save">Сохранить</button>
            <button type="button" class="btn btn-danger button-close" data-dismiss="modal">Закрыть</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="mb-3">
        <button type="button" class="btn btn-success button-savet" data-toggle="modal"
          data-target="#createCategoryModal">
          Добавить
        </button>
      </div>
      <div class="card">
        <div class="card-header border-0 m-2">
          <h3 class="card-title">Таблица Категорий</h3>

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
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap table-borderless table-striped">
            <thead>
              <tr>
                <th>Название</th>
                <th>Родительский жанр</th>
                <th style="width: 5%"></th>
              </tr>
            </thead>
            <tbody class="categories-list">
              @foreach ($categories as $category)
                <tr>
                  <th>
                    <a href="#" data-toggle="modal"
                      data-target="#editCategoryModal{{ $category->id }}">{{ $category->name }}</a>
                    <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" role="dialog"
                      aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">Редактировать категорию
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true" style="font-size: 2.5rem; color: #333333;">×</span>
                            </button>
                          </div>
                          <form action="{{ route('categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="modal-body">
                              <div class="form-group">
                                <label for="name">Название</label>
                                <input type="text" class="@error('name') is-invalid @enderror form-control"
                                  id="name" name="name"
                                  value="{{ old('name', isset($category) ? $category->name : '') }}">
                                @error('name')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                @enderror
                              </div>
                              <div style="col-md-6">
                                <div class="form-group">
                                  <label>Родительский жанр</label>
                                  <select class="form-control select2" style="width: 100%;" name="parent_id">
                                    <option value="">Нет родительского жанра</option>
                                    @foreach ($categories as $parentCategory)
                                      <option value="{{ $parentCategory->id }}">
                                        {{ $parentCategory->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
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
                  <td>{{ isset($category->parent) ? $category->parent->name : 'Нет родительского жанра' }}</td>
                  <td>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger button-close">Удалить</button>
                    </form>
                  </td>
                </tr>
              @endforeach
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
        let queries = query.split(' ');
        let categories = document.querySelectorAll('.categories-list tr');

        for (let i = 0; i < categories.length; i++) {
          let category = categories[i];
          let name = category.querySelector('th a').textContent;
          let parent = category.querySelector('td:nth-child(2)').textContent;

          let match = queries.every(function(q) {
            return name.toLowerCase().includes(q) || parent.toLowerCase().includes(q);
          });

          if (!match) {
            category.style.display = 'none';
          } else {
            category.style.display = '';
          }
        }
      });
    };
  </script>
@endsection
