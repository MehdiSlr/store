<ul class="navbar-nav justify-content-end">
  <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
      <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
      <div class="sidenav-toggler-inner">
        <i class="sidenav-toggler-line"></i>
        <i class="sidenav-toggler-line"></i>
        <i class="sidenav-toggler-line"></i>
      </div>
    </a>
  </li>
  <li class="nav-item px-3 d-flex align-items-center">
    <a href="javascript:;" class="nav-link text-body p-0">
      <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
    </a>
  </li>
  <li class="nav-item d-flex align-items-center">
      <div class="dropdown">
        <a class="nav-link text-body font-weight-bold px-0 dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user me-sm-1"></i>
          <span class="d-sm-inline d-none"><?= $name ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="/logout">Logout</a>
        </div>
      </div>
  </li>
</ul>