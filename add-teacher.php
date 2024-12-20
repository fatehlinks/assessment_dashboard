<?php include('user-auth.php'); ?>
<?php
//Set a session variable to trigger the SweetAlert
if (!empty($_SESSION['primary_sweetalert_displayed'])) {
    $displayprimarySweetAlert = true;
    unset($_SESSION['primary_sweetalert_displayed']);
}

// Fetch subjects from the database
include('config.php'); // Ensure you have the connection file included
$query = "SELECT subject_id, subject_name FROM subjects WHERE subject_status = 1";
$subjectsResult = mysqli_query($cn, $query);

// Fetch schools from the database
$select_schools = "SELECT * FROM schools WHERE school_status = 1"; // Only fetch active groups
$select_schools_run = mysqli_query($cn, $select_schools);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Teacher</title>
    <link rel="stylesheet" href="assets/bundles/select2/dist/css/select2.min.css" />

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
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <form class="needs-validation" novalidate="" method="post" action="insert-teacher.php">
                                        <div class="card-header">
                                            <h4><i data-feather="plus"></i> Add Teacher</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Name<span class="text-danger">*</span> :</label>
                                                        <input type="text" placeholder="Enter here..." onkeyup="this.value = this.value.toUpperCase();" class="form-control" required="" name="teacher_name">
                                                        <div class="invalid-feedback">
                                                            What's the teacher's name?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>CNIC<span class="text-danger">*</span> :</label>
                                                        <input type="text" data-inputmask="'mask':'99999-9999999-9'" placeholder="xxxxx-xxxxxxx-x" class="form-control" required="" name="teacher_cnic">
                                                        <div class="invalid-feedback">
                                                            What's the teacher's CNIC?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Joining Date<span class="text-danger">*</span> :</label>
                                                        <input type="date" class="form-control" required="" name="teacher_joining_date">
                                                        <div class="invalid-feedback">
                                                            What's the teacher's joining date?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Date of Birth</label>
                                                        <input type="date" class="form-control" required="" name="teacher_dob">
                                                        <div class="invalid-feedback">
                                                            What's the teacher's date of birth?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Mobile<span class="text-danger">*</span> : </label>
                                                        <input type="text" data-inputmask="'mask':'9999-9999999'" placeholder="xxxx-xxxxxxx" class="form-control" required="" name="teacher_mobile">
                                                        <div class="invalid-feedback">
                                                            Enter the teacher's mobile number.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Subject<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" required="" name="teacher_subject">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php
                                                            // Loop through the subjects and populate the dropdown
                                                            if (mysqli_num_rows($subjectsResult) > 0) {
                                                                while ($row = mysqli_fetch_assoc($subjectsResult)) {
                                                                    echo "<option value='" . $row['subject_id'] . "'>" . $row['subject_name'] . "</option>";
                                                                }
                                                            } else {
                                                                echo "<option disabled>No subjects available</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Choose the teacher's subject.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->


                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>School<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" id='school-select' required="" name="teacher_school">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php
                                                            // Loop through groups and add them as options in the select
                                                            while ($school = mysqli_fetch_assoc($select_schools_run)) {
                                                                echo "<option value='" . $school['school_id'] . "'>" . $school['school_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Select a school.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                            </div> <!-- /row -->

                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary" name='add-teacher-btn'><i class='fa fas fa-plus'></i> Save & Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="section">
                    <div class="section-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>CNIC</th>
                                                        <th>Mobile</th>
                                                        <th>Joining</th>
                                                        <th>DOB</th>
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
                                                        $teacher_joining_date = date("d-M-Y", strtotime($row['teacher_joining_date']));
                                                        $teacher_dob = date("d-M-Y", strtotime($row['teacher_dob']));
                                                        $teacher_mobile = $row['teacher_mobile'];
                                                        $subject_name = $row['subject_name'];
                                                        $teacher_status = $row['teacher_status'];

                                                        // Set the status display
                                                        if ($teacher_status == 1) {
                                                            $teacher_status_display = "<span class='badge badge-primary'>Active</span>";
                                                        } else {
                                                            $teacher_status_display = "<span class='badge badge-warning'>Inactive</span>";
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?= $teacher_name; ?></td>
                                                            <td><?= $teacher_cnic; ?></td>
                                                            <td><?= $teacher_mobile; ?></td>

                                                            <td><?= $teacher_joining_date ?></td>
                                                            <td><?= $teacher_dob ?></td>
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
<!-- masking -->
<script src="./assets/js/masking/jquery.inputmask.bundle.js"></script>
<script>
    $(":input").inputmask();
</script>

<!-- sweet alert -->
<?php if (!empty($displayprimarySweetAlert)): ?>
    <script>
        $(document).ready(function() {
            swal({
                title: "Congrats",
                text: "Operation Successfully completed.",
                icon: "primary",
                button: "OK"
            });
        });
    </script>
<?php endif; ?>