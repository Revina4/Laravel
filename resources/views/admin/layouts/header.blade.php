<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto align-items-center">
    <li class="nav-item mr-3 d-none d-sm-block">
      <span class="user-chip">
        <i class="fas fa-user-circle mr-1"></i> {{ auth()->user()->name }}
      </span>
    </li>
    <li class="nav-item">
      <a href="/logout" class="btn btn-sm btn-soft-danger">
        <i class="fas fa-sign-out-alt mr-1"></i> Keluar
      </a>
    </li>
  </ul>
</nav>