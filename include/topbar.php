<?php

// Function to insert birthday notifications
function insertBirthdayNotifications($cn)
{
  $today = date('m-d'); // Format: MM-DD
  $birthday_insert_query = "INSERT INTO birthday_notifications (birthday_teacher_id, birthday_notification_status)
                              SELECT teacher_id, 1 
                              FROM teachers 
                              WHERE DATE_FORMAT(teacher_dob, '%m-%d') = '$today'
                              AND teacher_id NOT IN (SELECT birthday_teacher_id FROM birthday_notifications)";
  mysqli_query($cn, $birthday_insert_query);
}

// Function to insert deadline notifications
function insertDeadlineNotifications($cn)
{
  $today = date('Y-m-d');
  $deadline_insert_query = "INSERT INTO deadline_notifications (deadline_assessment_id, deadline_notification_status)
                              SELECT assessment_id, 1 
                              FROM assessments 
                              WHERE assessment_deadline BETWEEN DATE_ADD('$today', INTERVAL 1 DAY) 
                              AND DATE_ADD('$today', INTERVAL 3 DAY) 
                              AND assessment_status = 1 
                              AND assessment_id NOT IN (SELECT deadline_assessment_id FROM deadline_notifications)";
  mysqli_query($cn, $deadline_insert_query);
}

// Run the insert functions
insertBirthdayNotifications($cn);
insertDeadlineNotifications($cn);

// Check for teacher birthdays
$today = date('m-d');
$birthday_query = "SELECT * FROM teachers 
                   JOIN birthday_notifications 
                   ON teachers.teacher_id = birthday_notifications.birthday_teacher_id 
                   WHERE DATE_FORMAT(teacher_dob, '%m-%d') = '$today'";
$birthday_result = mysqli_query($cn, $birthday_query);

$birthday_teachers = [];
if ($birthday_result && mysqli_num_rows($birthday_result) > 0) {
  while ($row = mysqli_fetch_assoc($birthday_result)) {
    $birthday_teachers[] = [
      'teacher_id' => $row['teacher_id'],
      'teacher_name' => $row['teacher_name']
    ];
  }
}

// Fetch upcoming assessment deadlines
$today = date('Y-m-d');
$upcoming_deadline_query = "SELECT a.assessment_id, a.assessment_subject, a.assessment_deadline 
                            FROM assessments a
                            JOIN deadline_notifications d
                            ON a.assessment_id = d.deadline_assessment_id
                            WHERE a.assessment_deadline >= '$today' 
                            AND a.assessment_status = 1 
                            AND d.deadline_notification_status = 1
                            ORDER BY a.assessment_deadline ASC";
$deadline_result = mysqli_query($cn, $upcoming_deadline_query);

$upcoming_assessments = [];
if ($deadline_result && mysqli_num_rows($deadline_result) > 0) {
  while ($row = mysqli_fetch_assoc($deadline_result)) {
    $upcoming_assessments[] = [
      'assessment_id' => $row['assessment_id'],
      'subject' => $row['assessment_subject'],
      'deadline' => $row['assessment_deadline']
    ];
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['mark_birthday_read'])) {
    $update_birthday_status_query = "UPDATE birthday_notifications SET birthday_notification_status = 0 
                                          WHERE birthday_notification_status = 1";
    $update_result = mysqli_query($cn, $update_birthday_status_query);

    if (!$update_result) {
      die("SQL Error while marking birthdays as read: " . mysqli_error($cn));
    }

    $birthday_teachers = []; // Clear the local array to stop showing notifications
  }

  // Update the assessment notifications status in the database
  if (isset($_POST['mark_assessment_read'])) {
    $update_deadline_status_query = "UPDATE deadline_notifications SET deadline_notification_status = 0 
                                          WHERE deadline_notification_status = 1";
    $update_result = mysqli_query($cn, $update_deadline_status_query);

    if (!$update_result) {
      die("SQL Error while marking assessments as read: " . mysqli_error($cn));
    }

    $upcoming_assessments = []; // Clear the local array to stop showing notifications
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
            <?php foreach ($birthday_teachers as $teacher): ?>
              <form method="POST" style="display: flex; align-items: center;">
                <input type="hidden" name="teacher_id" value="<?= $teacher['teacher_id']; ?>">
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <span class="dropdown-item-icon bg-light text-info">
                    <i class="fas fa-birthday-cake"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    <?= $teacher['teacher_name']; ?>
                    <span class="time">Today</span>
                  </span>
                </a>
              </form>
            <?php endforeach; ?>
          </div>
          <div class="dropdown-footer text-center">
            <form method="POST">
              <button type="submit" name="mark_birthday_read" class="btn btn-link">Mark All as Read</button>
            </form>
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
              <form method="POST" style="display: flex; align-items: center;">
                <input type="hidden" name="assessment_id" value="<?= $assessment['assessment_id']; ?>">
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-icon bg-warning text-white">
                    <i class="fas fa-exclamation-circle"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    Assessment - <?= $assessment['subject']; ?>
                    <span class="time">Deadline <?= date('d M Y', strtotime($assessment['deadline'])); ?></span>
                  </span>
                </a>
              </form>
            <?php endforeach; ?>
          </div>
          <div class="dropdown-footer text-center">
            <form method="POST">
              <button type="submit" name="mark_assessment_read" class="btn btn-link">Mark All as Read</button>
            </form>
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