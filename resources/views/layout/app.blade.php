<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/assets/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/assets/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/css/adminlte.min.css">

  <link rel="stylesheet" href="/assets/css/customcss.css">

  <style>
    .custom-loader {
      width:80px;
      height:80px;
      border-radius:50%;
      background:conic-gradient(#0000 30%,white);
      -webkit-mask:radial-gradient(farthest-side,#0000 calc(100% - 16px),#000 0);
      animation:s3 1s infinite linear;
    }
    .webgl,
    #loader {
      position: fixed;
      top: 0;
      left: 0;
      background-color: #FAEDCD;
    }

    #loader {
      display: grid;
      place-content: center;
      width: 100%;
      height: 100%;
      background-color: #FAEDCD;
    }
    @keyframes s3 {to{transform: rotate(1turn)}}
  </style>

</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

  
<div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-labelledby="adminModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 43%; max-width: 43%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="adminModalLabel">Профиль админа</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
          <span aria-hidden="true" style="font-size: 2.5rem; color: #333333;">×</span>
        </button>
      </div>
      <div class="modal-body m-2 p-lg-5">
        <div class="row">
          <div class="col-md-5 d-flex flex-column align-items-center">
            <img src="{{ Auth::guard('admin')->user()->img_link ?? '/assets/img/user2-160x160.jpg' }}" style="width: 220px; height: 220px;" class="img-circle" alt="Фото админа">
            <a class="edit-button-form" href="#" id="edit-img_link-btn" style="text-decoration: none; color: inherit; padding-left: 155px; margin-bottom: 50px; position: absolute; color: black;">
                <i class="fa fa-solid fa-pen"></i>
            </a>
            <p style="font-size: 30px; font-weight: 500; color: #333333;">{{ Auth::guard('admin')->user()->username }}</p>
            <p style="font-size: 16px; margin-top: -5%; color: #333333;">Глав. Админ</p>
          </div>
          <div class="col-md-7">
            <p class="fs-2 d-flex align-items-center" style="font-size: 1.2rem; color: #333333;">
                Имя пользователя: {{ Auth::guard('admin')->user()->username }}
                <a class="edit-button-form" href="#" id="edit-name-btn" style="text-decoration: none; color: inherit; margin-left: 10px;">
                    <i class="fa fa-solid fa-pen" style="color: black;"></i>
                </a>
            </p>
            <p class="fs-2 d-flex align-items-center" style="font-size: 1.2rem; color: #333333;">
                Email: {{ Auth::guard('admin')->user()->email }}
                <a class="edit-button-form" href="#" id="edit-email-btn" style="text-decoration: none; color: inherit; margin-left: 10px;">
                    <i class="fa fa-solid fa-pen" style="color: black;"></i>
                </a>
            </p>
            <p class="fs-2 d-flex align-items-center" style="color: #333333;">
                Изменить пароль
                <a class="edit-button-form" href="#" id="edit-password-btn" style="text-decoration: none; color: inherit; margin-left: 10px;">
                    <i class="fa fa-solid fa-pen" style="color: black;"></i>
                </a>
            </p>
            <form action="{{ route('admin.update') }}" method="POST" id="update-profile-form">
              @csrf
              @method('POST')
  
              <div id="name-input" class="form-group" style="display: none;">
                  <label for="name">Имя пользователя</label>
                  <input type="text" class="form-control" name="username" value="{{ Auth::guard('admin')->user()->username }}">
              </div>
  
              <div id="email-input" class="form-group" style="display: none;">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="{{ Auth::guard('admin')->user()->email }}">
              </div>
  
              <div id="img_link-input" class="form-group" style="display: none;">
                  <label for="img_link">Аватар (Ссылка)</label>
                  <input type="img_link" class="form-control" id="img_link" name="img_link" value="{{ Auth::guard('admin')->user()->img_link }}">
              </div>
  
              <div id="password-input" class="form-group" style="display: none;">
                  <label for="password">Новый пароль</label>
                  <input type="password" class="form-control" id="password" name="password">
                  <label for="password_confirmation">Подтвердите новый пароль</label>
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
              </div>
  
              <button type="button" id="save-changes-btn" class="btn btn-sm btn-success button-68" style="margin-left: 5px;">Сохранить изменения</button>
  
              <div class="modal" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                <div class="div-fade-back" style="width: 100%; height:100%; position:absolute; background-color: rgba(0,0,0,0.6)"></div>
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="confirmationModalLabel">Подтверждение изменений</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true" style="font-size: 2.5rem; color: #333333;">&times;</span>
                              </button>
                          </div>
                          
                          <div class="modal-body">
                              Вы действительно хотите применить изменения?
                              <div class="form-group">
                                  <label for="confirm_password">Подтвердите пароль</label>
                                  <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                              </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary button-close" data-dismiss="modal">Отменить</button>
                              <button type="submit" form="update-profile-form" class="btn btn-primary button-save">Сохранить</button>
                          </div>
                      </div>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary button-close" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <div class="custom-loader"></div>
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <div class="d-flex flex-col">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars burger"></i></a>
          <p class="dashboardtext">Админ панель</p>
        </div>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt arrows-fa"></i>
        </a>
      </li>
    </ul>
    <div>
      <form action="{{ route('logout') }}" method="POST"> 
        @csrf
        <button class='btn btn-primary button-logout'>Log out</button>
      </form>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      
      <span class="brand-text font-weight-light">Kinotower</span>
    </a>
    
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
    
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ Auth::guard('admin')->user()->img_link }}" class="img-circle" alt="Фото админа" style="width: 50px; height: 50px;">
        </div>
        <div class="container">
          <ul class="nav nav-pills nav-sidebar">
            <li class="nav-item">
                <a class="nav-link" style="margin-top: 8px" href="#" data-toggle="modal" data-target="#adminModal">{{ Auth::guard('admin')->user()->username }}</a>
            </li>
          </ul>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2 menu-list">
        <ul class="nav nav-pills nav-sidebar flex-column nav-menu" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('countries.index') }}" class="nav-link">
              <i class="fas fa-solid fa-globe m-2"></i>
              <p>Страны</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link">
              <i class="fas fa-solid fa-icons m-2"></i>
              <p>Жанры</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('films.index') }}" class="nav-link">
              <i class="fas fa-solid fa-film m-2"></i>
              <p>Фильмы</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('categoryfilms.index') }}" class="nav-link">
              <i class="nav-icon fas fa-video m-2"></i>
              <p>Категории и Фильмы</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link">
              <i class="fas fa-solid fa-user m-2"></i>
              <p>Пользователи</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('reviews.index') }}" class="nav-link">
              <i class="fas fa-solid fa-comments m-2"></i>
              <p>Отзывы</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('ratings.index') }}" class="nav-link">
              <i class="fas fa-regular fa-star m-2"></i>
              <p>Оценки</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">@yield('title')</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
            @yield('content')
 
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2024 <a href="https://kinotower.kz">kinotower.kz</a>.</strong>
    All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="/assets/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="/assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/js/adminlte.js"></script>

<script src="/assets/js/customjs.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r124/three.min.js" defer></script>
<script src="https://unpkg.com/three@0.126.0/examples/js/loaders/GLTFLoader.js" defer></script>
<script src="https://unpkg.com/three@0.126.0/examples/js/controls/OrbitControls.js" defer></script>

<script src="/assets/main.js" defer></script>

<script>
$(document).ready(function () {
    $("#save-changes-btn").click(function (e) {
        e.preventDefault();
        $("#confirmationModal").modal("show");
    });
});
</script>
</body>
</html>
