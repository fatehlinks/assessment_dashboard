<?php include('auth.php'); ?>
<?php
// Set a session variable to trigger the SweetAlert
if (!empty($_SESSION['success_sweetalert_displayed'])) {
    $displaySuccessSweetAlert = true;
    unset($_SESSION['success_sweetalert_displayed']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>View students</title>
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
                                        <h4><i data-feather="bar-chart"></i> Students List</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>CNIC</th>
                                                        <th>Mobile</th>
                                                        <th>Subject</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Fetch student data from the database
                                                    $select_student_data = "SELECT students.*, groups.group_name 
                                                                            FROM students 
                                                                            JOIN groups ON students.student_group = groups.group_id WHERE student_status != -1";
                                                    $select_student_data_run = mysqli_query($cn, $select_student_data);

                                                    while ($row = mysqli_fetch_assoc($select_student_data_run)) {
                                                        $student_id = $row['student_id'];
                                                        $student_name = $row['student_name'];
                                                        $student_cnic = $row['student_cnic'];
                                                        $student_mobile = $row['student_mobile'];
                                                        $student_group = $row['group_name'];
                                                        $student_status = $row['student_status'];

                                                        // Set the status display
                                                        if ($student_status == 1) {
                                                            $student_status_display = "<span class='badge badge-success'>Active</span>";
                                                        } else {
                                                            $student_status_display = "<span class='badge badge-warning'>Inactive</span>";
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?= $student_name; ?></td>
                                                            <td><?= $student_cnic; ?></td>
                                                            <td><?= $student_mobile; ?></td>
                                                            <td><?= $student_group; ?></td>
                                                            <td><?= $student_status_display; ?></td>
                                                            <td>
                                                                <div class="dropdown form-control-sm">
                                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                                                        Action
                                                                    </button>
                                                                    <div class="dropdown-menu">

                                                                        <a class="dropdown-item" href="student-active.php?id=<?= $student_id; ?>"><i class='fa fa-check-circle'></i> Active</a>
                                                                        <a class="dropdown-item" href="student-inactive.php?id=<?= $student_id; ?>"><i class='fa fa-times-circle'></i> Inactive</a>
                                                                        <a class="dropdown-item" href="edit-student.php?id=<?= $student_id; ?>"><i class='fa fa-edit'></i> Edit</a>
                                                                        <a class="dropdown-item" href="delete-student.php?id=<?= $student_id; ?>"><i class='fa fa-trash'></i> Delete</a>
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

<!-- SweetAlert Script -->
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