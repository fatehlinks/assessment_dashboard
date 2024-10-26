<?php

// Query to get today’s birthdays
$today = date('Y-m-d');
$birthday_query = "SELECT teacher_id, teacher_name FROM teachers WHERE DATE(teacher_dob) = '$today' AND birthday_read = 0";
$birthday_result = mysqli_query($cn, $birthday_query);
$birthday_count = mysqli_num_rows($birthday_result);

// Query to get upcoming assessment deadlines (within the next 7 days)
$deadline_query = "SELECT assessment_id,  assessment_deadline 
                   FROM assessments 
                   WHERE DATE(assessment_deadline) >= '$today' 
                   AND DATE(assessment_deadline) <= DATE_ADD('$today', INTERVAL 7 DAY) AND assessment_read_flag = 0";
$deadline_result = mysqli_query($cn, $deadline_query);
$deadline_count = mysqli_num_rows($deadline_result);

// Mark birthdays as read
if (isset($_POST['mark_birthday_read'])) {
  // Example of setting birthday as read (optional flag or session based on requirements)
  mysqli_query($cn, "UPDATE teachers SET birthday_read = 1 WHERE DATE(teacher_dob) = '$today'");
}

// Mark assessment deadlines as read
if (isset($_POST['mark_assessment_read'])) {
  mysqli_query($cn, "UPDATE assessments SET assessment_read_flag = 1 
                       WHERE assessment_deadline BETWEEN '$today' AND DATE_ADD('$today', INTERVAL 7 DAY)");
}
?>


<nav class="navbar navbar-expand-lg main-navbar sticky">
  <div class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"><i data-feather="align-justify"></i></a></li>
      <li><a href="#" class="nav-link nav-link-lg fullscreen-btn"><i data-feather="maximize"></i></a></li>
      <li>
        <form class="form-inline mr-auto">
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
          </div>
        </form>
      </li>
    </ul>
  </div>
  <ul class="navbar-nav navbar-right">
    <!-- Birthday Notification Section -->
    <li class="dropdown dropdown-list-toggle">
      <?php if ($birthday_count > 0): ?>
        <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg notification-toggle">
          <i data-feather="gift"></i>
          <span class="badge badge-primary badge-notification"><?= $birthday_count; ?></span>
        </a>
      <?php endif; ?>
      <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
        <div class="dropdown-header">Birthdays Today</div>
        <div class="dropdown-list-content dropdown-list-icons bg-white">
          <?php if ($birthday_count > 0): ?>
            <?php while ($birthday = mysqli_fetch_assoc($birthday_result)): ?>
              <a href="#" class="dropdown-item dropdown-item-unread d-flex align-items-center">
                <span class="dropdown-item-icon bg-light text-info">
                  <i class="fas fa-birthday-cake"></i>
                </span>
                <span class="dropdown-item-desc">
                  <?= $birthday['teacher_name']; ?>
                </span>
              </a>
            <?php endwhile; ?>
          <?php else: ?>
            <div class="text-center p-2">No Birthdays Today</div>
          <?php endif; ?>
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
      <?php if ($deadline_count > 0): ?>
        <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg notification-toggle">
          <i data-feather="clock"></i>
          <span class="badge badge-danger badge-notification"><?= $deadline_count; ?></span>
        </a>
      <?php endif; ?>
      <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
        <div class="dropdown-header">Upcoming Assessment Deadlines</div>
        <div class="dropdown-list-content dropdown-list-icons">
          <?php if ($deadline_count > 0): ?>
            <?php while ($deadline = mysqli_fetch_assoc($deadline_result)): ?>
              <a href="#" class="dropdown-item">
                <span class="dropdown-item-icon bg-warning text-white">
                  <i class="fas fa-exclamation-circle"></i>
                </span>
                <span class="dropdown-item-desc">
                  <?= 'Assessment-' . $deadline['assessment_id']; ?>
                  <span class="time">Due on <?= date('M d, Y', strtotime($deadline['assessment_deadline'])); ?></span>
                </span>
              </a>
            <?php endwhile; ?>
          <?php else: ?>
            <div class="text-center p-2">No Deadlines This Week</div>
          <?php endif; ?>
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
      </a>
      <div class="dropdown-menu dropdown-menu-right pullDown">
        <div class="dropdown-title"><?= $admin_name; ?></div>
        <a href="admin-profile.php" class="dropdown-item has-icon"><i class="far fa-user"></i> Profile</a>
        <div class="dropdown-divider"></div>
        <a href="logout.php" class="dropdown-item has-icon text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
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