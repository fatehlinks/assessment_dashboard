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
    <title>View Teachers</title>
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
                                        <h4><i data-feather="bar-chart"></i> Teachers List</h4>
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
                                                    // Fetch teacher data from the database
                                                    $select_teacher_data = "SELECT teachers.*, subjects.subject_name 
                                                                            FROM teachers 
                                                                            JOIN subjects ON teachers.teacher_subject = subjects.subject_id";
                                                    $select_teacher_data_run = mysqli_query($cn, $select_teacher_data);

                                                    while ($row = mysqli_fetch_assoc($select_teacher_data_run)) {
                                                        $teacher_id = $row['teacher_id'];
                                                        $teacher_name = $row['teacher_name'];
                                                        $teacher_cnic = $row['teacher_cnic'];
                                                        $teacher_mobile = $row['teacher_mobile'];
                                                        $subject_name = $row['subject_name'];
                                                        $teacher_status = $row['teacher_status'];

                                                        // Set the status display
                                                        if ($teacher_status == 1) {
                                                            $teacher_status_display = "<span class='badge badge-success'>Active</span>";
                                                        } else {
                                                            $teacher_status_display = "<span class='badge badge-warning'>Inactive</span>";
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?= $teacher_name; ?></td>
                                                            <td><?= $teacher_cnic; ?></td>
                                                            <td><?= $teacher_mobile; ?></td>
                                                            <td><?= $subject_name; ?></td>
                                                            <td><?= $teacher_status_display; ?></td>
                                                            <td>
                                                                <div class="dropdown form-control-sm">
                                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                                                        Action
                                                                    </button>
                                                                    <div class="dropdown-menu">

                                                                        <a class="dropdown-item" href="teacher-active.php?id=<?= $teacher_id; ?>"><i class='fa fa-check-circle'></i> Active</a>
                                                                        <a class="dropdown-item" href="teacher-inactive.php?id=<?= $teacher_id; ?>"><i class='fa fa-times-circle'></i> Inactive</a>
                                                                        <a class="dropdown-item" href="edit-teacher.php?id=<?= $teacher_id; ?>"><i class='fa fa-edit'></i> Edit</a>
                                                                        <a class="dropdown-item" href="delete-teacher.php?id=<?= $teacher_id; ?>"><i class='fa fa-trash'></i> Delete</a>
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