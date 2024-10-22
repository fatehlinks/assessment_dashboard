<?php
// Check for teacher birthdays
$today = date('m-d'); // Format: MM-DD
$birthday_query = "SELECT teacher_name FROM teachers WHERE DATE_FORMAT(teacher_dob, '%m-%d') = '$today' AND teacher_status = 1";
$birthday_result = mysqli_query($cn, $birthday_query);

$birthday_teachers = [];
if ($birthday_result && mysqli_num_rows($birthday_result) > 0) {
  while ($row = mysqli_fetch_assoc($birthday_result)) {
    $birthday_teachers[] = $row['teacher_name'];
  }
}


// Fetch upcoming assessment deadlines (e.g., within the next 7 days)
$today = date('Y-m-d');
$upcoming_deadline_query = "SELECT assessment_subject, assessment_deadline 
                                FROM assessments 
                                WHERE assessment_deadline >= '$today' 
                                AND assessment_status = 1 
                                ORDER BY assessment_deadline ASC";
$deadline_result = mysqli_query($cn, $upcoming_deadline_query);

$upcoming_assessments = [];
if ($deadline_result && mysqli_num_rows($deadline_result) > 0) {
  while ($row = mysqli_fetch_assoc($deadline_result)) {
    $upcoming_assessments[] = [
      'subject' => $row['assessment_subject'],
      'deadline' => $row['assessment_deadline']
    ];
  }
}
?>




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
    <?php if (!empty($birthday_teachers)): ?>
      <li class="dropdown dropdown-list-toggle">
        <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg notification-toggle">
          <i data-feather="gift"></i>
          <span class="badge badge-primary badge-notification"><?= count($birthday_teachers); ?></span>
        </a>
        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
          <div class="dropdown-header">Birthdays Today</div>
          <div class="dropdown-list-content dropdown-list-icons bg-white">
            <?php foreach ($birthday_teachers as $teacher_name): ?>
              <a href="#" class="dropdown-item dropdown-item-unread">
                <span class="dropdown-item-icon bg-light text-info">
                  <i class="fas fa-birthday-cake"></i>
                </span>
                <span class="dropdown-item-desc">
                  <?= $teacher_name; ?>
                  <span class="time">Today</span>
                </span>
              </a>
            <?php endforeach; ?>
          </div>
          <div class="dropdown-footer text-center">
            <a href="#">View All <i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
      </li>
    <?php endif; ?>

    <!-- Assessment Deadline Notification Section -->
    <?php if (!empty($upcoming_assessments)): ?>
      <li class="dropdown dropdown-list-toggle">
        <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg notification-toggle">
          <i data-feather="clock"></i>
          <span class="badge badge-danger badge-notification"><?= count($upcoming_assessments); ?></span>
        </a>
        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
          <div class="dropdown-header">Upcoming Assessment Deadlines</div>
          <div class="dropdown-list-content dropdown-list-icons">
            <?php foreach ($upcoming_assessments as $assessment): ?>
              <a href="#" class="dropdown-item">
                <span class="dropdown-item-icon bg-warning text-white">
                  <i class="fas fa-exclamation-circle"></i>
                </span>
                <span class="dropdown-item-desc">
                  <?= $assessment['subject']; ?>
                  <span class="time">Deadline: <?= date('d M Y', strtotime($assessment['deadline'])); ?></span>
                </span>
              </a>
            <?php endforeach; ?>
          </div>
          <div class="dropdown-footer text-center">
            <a href="#">View All <i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
      </li>
    <?php endif; ?>

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