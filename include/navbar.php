<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="dashboard.php"> <img alt="image" src="./assets/img/favicon.png" class="header-logo" /> <span
          class="logo-name">Admin</span>
      </a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Main</li>
      <li class="dropdown">
        <a href="dashboard.php" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
      </li>

      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="users"></i><span>Students</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="add-student.php">Add Student</a></li>
          <li><a class="nav-link" href="view-students.php">View Students</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="clipboard"></i><span>Assessment</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="add-assessment.php">Add Assessment</a></li>
          <li><a class="nav-link" href="view-assessment.php">View Assessments</a></li>
          <li><a class="nav-link" href="filter.php">Filter Result</a></li>
        </ul>
      </li>

      <?php


      if ($admin_row['admin_role'] == 0) {

        echo '<li class="menu-header">Settings</li>

              <li class="dropdown">
                  <a href="add-school.php" class="nav-link"><i data-feather="home"></i><span>School</span></a>
              </li>

              <li class="dropdown">
                  <a href="add-group.php" class="nav-link"><i data-feather="layers"></i><span>Group</span></a>
              </li>
              
              <li class="dropdown">
                  <a href="add-category.php" class="nav-link"><i data-feather="server"></i><span>Category</span></a>
              </li>

              <li class="dropdown">
                  <a href="add-subject.php" class="nav-link"><i data-feather="book"></i><span>Subject</span></a>
              </li>

              <li class="dropdown">
                  <a href="add-teacher.php" class="nav-link"><i data-feather="users"></i><span>Teacher</span></a>
              </li>

              <li class="dropdown">
                  <a href="admin-profile.php" class="nav-link"><i data-feather="user-plus"></i><span>Admin</span></a>
              </li>';
      }
      ?>




    </ul>
  </aside>
</div>