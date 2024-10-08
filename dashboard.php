<?php include('auth.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <?php include_once('include/html-sources.html'); ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
        <?php include_once('include/topbar.php'); ?>
        <?php include_once('include/navbar.php'); ?>
      <!-- Main Content -->
      <?php include_once('include/dashboard.php'); ?>
      <?php include_once('include/footer.php'); ?>
      </div>
  </div>
 
</body>

</html>
<?php include_once('include/js-sources.html'); ?>