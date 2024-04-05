@extends('layout.app')

@section('title','Пользователи')

@section('content')
<div class="modal fade" id="createUserModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Создать пользователя</h4>
        <button type="button" class="close" data-dismiss="modal" style="font-size: 2.5rem; color: #333333;">&times;</button>
      </div>
      <div class="modal-body">
        <form action="{{ route('users.store') }}" method="POST">
          @csrf
          @method('POST')
          <div class="form-group">
            <label for="fio">ФИО</label>
            <input 
                type="text" 
                class="@error('fio') is-invalid @enderror form-control" 
                id="fio" 
                name="fio"
                value="{{ old('fio', isset($user) ? $user->fio : '')}}"
                >
                @error('fio')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input 
                type="email" 
                class="@error('email') is-invalid @enderror form-control" 
                id="email" 
                name="email"
                value="{{ old('email', isset($user) ? $user->email : '')}}"
                >
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
          </div>
          <div class="form-group">
            <label for="password">Введите новый пароль</label>
            <input 
                type="password" 
                class="@error('password') is-invalid @enderror form-control" 
                id="password" 
                name="password"
                value="{{ old('password', isset($user) ? $user->password : '')}}"
                >
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
          </div>
          <div class="form-group">
            <label for="birthday">Дата рождения</label>
            <input 
                type="date" 
                class="@error('birthday') is-invalid @enderror form-control" 
                id="birthday" 
                name="birthday"
                value="{{ old('birthday', isset($user) ? $user->birthday : '')}}"
                >
                @error('birthday')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
          </div>
          <div class="form-group">
            <label for="genders">Гендер</label>
            <select 
            class="@error('gender_id') is-invalid @enderror form-control select2" 
            style="width: 100%;" 
            id="gender_id" 
            name="gender_id">
              @foreach ($genders as $gender)
              <option value="{{ $gender->id }}" {{ old('gender_id', isset($user) ? $user->gender_id : '1') == $gender->id ? 'selected' : '1' }}>
                {{ $gender->name }}
              </option>
              @endforeach
            </select>
            @error('genders')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
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
      <button type="button" class="btn btn-success button-savet" data-toggle="modal" data-target="#createUserModal">
          Добавить
      </button>
    </div>
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
    <div class="table-responsive p-0 d-flex flex-row">
      <div class="col" >
        <table class="table table-hover table-borderless table-striped table-responsive table-minimal smaller-table">
          <h2 class="text-center">Список пользователей</h2>
          <thead>
            <tr>
              <th style="width: 15%; font-weight:700">ФИО</th>
              <th style="width: 25%;">Пол</th>
              <th style="width: 30%;">Email</th>
              <th style="width: 20%;" colspan="2">Действие</th>
            </tr>
          </thead>
          <tbody class="users-list">
            @foreach ($users as $user)
            <tr>
              <td style="width: 25%; font-weight:700">{{ $user->fio }}</td>
              <td style="width: 25%;">{{ $user->gender->name }}</td>
              <td style="width: 30%">{{ $user->email }}</td>
              <td style="width: 10%;">
                <button type="submit" class="btn btn-sm btn-primary button-save" data-toggle="modal" data-target="#myModal{{ $user->id }}">Изменить</button>
                  <div class="modal fade" id="myModal{{ $user->id }}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Редактировать пользователя</h4>
                          <button type="button" class="close" data-dismiss="modal" style="font-size: 2.5rem; color: #333333;">&times;</button>
                        </div>
                        <div class="modal-body">
                          <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                              <label for="fio">ФИО</label>
                              <input 
                                  type="text" 
                                  class="@error('fio') is-invalid @enderror form-control" 
                                  id="fio" 
                                  name="fio"
                                  value="{{ old('fio', isset($user) ? $user->fio : '')}}"
                                  >
                                  @error('fio')
                                  <div class="invalid-feedback">
                                      {{ $message }}
                                  </div>
                                  @enderror
                            </div>
                            <div class="form-group">
                              <label for="email">Email</label>
                              <input 
                                  type="email" 
                                  class="@error('email') is-invalid @enderror form-control" 
                                  id="email" 
                                  name="email"
                                  value="{{ old('email', isset($user) ? $user->email : '')}}"
                                  >
                                  @error('email')
                                  <div class="invalid-feedback">
                                      {{ $message }}
                                  </div>
                                  @enderror
                            </div>
                            <div class="form-group">
                              <label for="password">Введите новый пароль</label>
                              <input 
                                  type="password" 
                                  class="@error('password') is-invalid @enderror form-control" 
                                  id="password" 
                                  name="password"
                                  value="{{ old('password', isset($user) ? $user->password : '')}}"
                                  >
                                  @error('password')
                                  <div class="invalid-feedback">
                                      {{ $message }}
                                  </div>
                                  @enderror
                            </div>
                            <div class="form-group">
                              <label for="birthday">Дата рождения</label>
                              <input 
                                  type="date" 
                                  class="@error('birthday') is-invalid @enderror form-control" 
                                  id="birthday" 
                                  name="birthday"
                                  value="{{ old('birthday', isset($user) ? $user->birthday : '')}}"
                                  >
                                  @error('birthday')
                                  <div class="invalid-feedback">
                                      {{ $message }}
                                  </div>
                                  @enderror
                            </div>
                            <div class="form-group">
                              <label for="genders">Гендер</label>
                              <select 
                              class="@error('gender_id') is-invalid @enderror form-control select2" 
                              style="width: 100%;" 
                              id="gender_id" 
                              name="gender_id">
                                @foreach ($genders as $gender)
                                <option value="{{ $gender->id }}" {{ old('gender_id', isset($user) ? $user->gender_id : '') == $gender->id ? 'selected' : '' }}>
                                  {{ $gender->name }}
                                </option>
                                @endforeach
                              </select>
                              @error('genders')
                              <div class="invalid-feedback">
                                  {{ $message }}
                              </div>
                              @enderror
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
              </td>
              <td style="width: 10%;">
                <form action="{{ route('admins.users.ban', $user->id) }}" method="post">
                  @csrf
                  @method('delete')
                  <button type="submit" class="btn btn-sm btn-danger button-close">Забанить</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="col">
        <table class="table table-hover table-borderless table-striped table-responsive table-minimal smaller-table">
          <h2 class="text-center">Забаненные пользователи</h2>
          <thead>
            <tr>
              <th style="width: 25%; font-weight:700">ФИО</th>
              <th style="width: 25%;">Пол</th>
              <th style="width: 30%;">Email</th>
              <th style="width: 20%;">Действие</th>
            </tr>
          </thead>
          <tbody class="users-list">
            @foreach ($deletedUsers as $user)
            <tr>
              <td style="width: 25%; font-weight:700">{{ $user->fio }}</td>
              <td style="width: 25%;">{{ $user->gender->name }}</td>
              <td style="width: 30%;">{{ $user->email }}</td>
              <td style="width: 20%;">
                <form action="{{ route('admins.users.restore', $user->id) }}" method="post">
                  @csrf
                  @method('put')
                  <button type="submit" class="btn btn-sm btn-success button-save">Восстановить</button>
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
<style>
    .smaller-table {
        font-size: 0.9em;
    }
</style>
<script>
window.onload = function() {
    let search = document.getElementById('search');
    search.addEventListener('keyup', function() {
        let query = search.value.toLowerCase();
        let queries = query.split(' ');
        let users = document.querySelectorAll('.users-list tr');
        
        for (let i = 0; i < users.length; i++) {
            let user = users[i];
            let fio = user.children[0].textContent;
            let gender = user.children[1].textContent;
            let email = user.children[2].textContent;
            
            let match = queries.every(function(q) {
                return fio.toLowerCase().includes(q) || gender.toLowerCase().includes(q) || email.toLowerCase().includes(q);
            });
            
            if (!match) {
                user.style.display = 'none';
            } else {
                user.style.display = '';
            }
        }
    });
};


</script>
@endsection
