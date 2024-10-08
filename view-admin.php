<?php include('auth.php'); ?>
<?php
//Set a session variable to trigger the SweetAlert
if (!empty($_SESSION['success_sweetalert_displayed'])) {
  $displaySuccessSweetAlert = true;
  unset($_SESSION['success_sweetalert_displayed']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>View Admin</title>
  <?php include_once('include/html-sources.html'); ?>
</head>

<body>

  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <?php include_once('include/topbar.php'); ?>
      <?php include_once('include/navbar.php'); ?>


      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4><i data-feather="bar-chart"></i> Admin User's</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                        <thead>
                          <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Recovery Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $select_admin_data = "SELECT * FROM admin";
                          $select_admin_data_run = mysqli_query($cn, $select_admin_data);
                          while ($row = mysqli_fetch_assoc($select_admin_data_run)) {
                            $admin_id = $row['admin_id'];
                            $admin_name = $row['admin_name'];
                            $admin_email = $row['admin_email'];
                            $admin_role = $row['admin_role'];
                            if ($admin_role == 1) {
                              $admin_role = "Super admin";
                            } else {
                              $admin_role = "Admin";
                            }
                            $admin_username = $row['admin_username'];
                            $admin_recovery_email = $row['admin_recovery_email'];
                            $admin_status = $row['admin_status'];
                            if ($admin_status == 1) {
                              $admin_status = "<span class='badge badge-success'>Active</span>";
                            } else {
                              $admin_status = "<span class='badge badge-warning'>Inactive</span>";
                            }

                          ?>
                            <tr>
                              <td><?= $admin_username; ?></td>
                              <td><?= $admin_name; ?></td>
                              <td><?= $admin_email; ?></td>
                              <td><?= $admin_recovery_email; ?></td>
                              <td><?= $admin_role; ?></td>
                              <td><?= $admin_status; ?></td>
                              <td>
                                <div class="dropdown form-control-sm">
                                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action
                                  </button>
                                  <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#"><i class='fa fa-edit'></i> Edit </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="delete-admin.php?id=<?= $admin_id; ?>"><i class='fa fa-trash'></i> Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>



      </div>


      <?php include_once('include/footer.php'); ?>
    </div>
  </div>

</body>

</html>


<?php include_once('include/js-sources.html'); ?>

<?php if (!empty($displaySuccessSweetAlert)): ?>
  <script>
    $(document).ready(function() {
      swal({
        title: "Congrats",
        text: "Operation successfully completed.",
        icon: "success",
        button: "OK"
      });
    });
  </script>
<?php endif; ?>