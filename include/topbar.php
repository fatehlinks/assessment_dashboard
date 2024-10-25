<nav class="navbar navbar-expand-lg main-navbar sticky">
  <div class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
          <i data-feather="align-justify"></i></a></li>
      <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
          <i data-feather="maximize"></i>
        </a></li>
      <li>
        <form class="form-inline mr-auto">
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
            <button class="btn" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </form>
      </li>
    </ul>
  </div>
  <ul class="navbar-nav navbar-right">

    <!-- Birthday Notification Section -->

    <li class="dropdown dropdown-list-toggle">
      <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg notification-toggle">
        <i data-feather="gift"></i>
        <span class="badge badge-primary badge-notification">0</span>
      </a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
        <div class="dropdown-header">Birthdays Today</div>
        <div class="dropdown-list-content dropdown-list-icons bg-white">

          <form method="POST" style="display: flex; align-items: center;">
            <input type="hidden" name="teacher_id" value="">
            <a href="#" class="dropdown-item dropdown-item-unread">
              <span class="dropdown-item-icon bg-light text-info">
                <i class="fas fa-birthday-cake"></i>
              </span>
              <span class="dropdown-item-desc">

                <span class="time">Today</span>
              </span>
            </a>
          </form>

        </div>
        <div class="dropdown-footer text-center">
          <form method="POST">
            <button type="submit" name="mark_birthday_read" class="btn btn-link">Mark All as Read</button>
          </form>
        </div>
      </div>
    </li>


    <!-- Assessment Deadline Notification Section -->

    <li class="dropdown dropdown-list-toggle">
      <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg notification-toggle">
        <i data-feather="clock"></i>
        <span class="badge badge-danger badge-notification">0</span>
      </a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
        <div class="dropdown-header">Upcoming Assessment Deadlines</div>
        <div class="dropdown-list-content dropdown-list-icons">

          <form method="POST" style="display: flex; align-items: center;">
            <input type="hidden" name="assessment_id" value="">
            <a href="#" class="dropdown-item">
              <span class="dropdown-item-icon bg-warning text-white">
                <i class="fas fa-exclamation-circle"></i>
              </span>
              <span class="dropdown-item-desc">
                Assessment -
                <span class="time">Deadline </span>
              </span>
            </a>
          </form>

        </div>
        <div class="dropdown-footer text-center">
          <form method="POST">
            <button type="submit" name="mark_assessment_read" class="btn btn-link">Mark All as Read</button>
          </form>
        </div>
      </div>
    </li>


    <!-- User Profile Section -->
    <li class="dropdown">
      <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="assets/img/user-profile.png" class="user-img-radious-style">
        <span class="d-sm-none d-lg-inline-block"></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right pullDown">
        <div class="dropdown-title"><?= $admin_name; ?></div>
        <a href="admin-profile.php" class="dropdown-item has-icon">
          <i class="far fa-user"></i> Profile
        </a>
        <div class="dropdown-divider"></div>
        <a href="logout.php" class="dropdown-item has-icon text-danger">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav>

<style>
  .badge-notification {
    position: absolute;
    top: -5px;
    right: -5px;
    padding: 5px 8px;
    border-radius: 50%;
    background-color: #dc3545;
    color: white;
    font-size: 10px;
  }
</style>