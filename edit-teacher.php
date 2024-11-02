<?php include('user-auth.php'); ?>

<?php
// Get teacher ID from query string
if (isset($_GET['id'])) {
    $teacher_id = mysqli_real_escape_string($cn, $_GET['id']);

    // Fetch the teacher's current data
    $get_teacher_qry = "SELECT * FROM teachers WHERE teacher_id = '$teacher_id'";
    $get_teacher_run = mysqli_query($cn, $get_teacher_qry);
    $teacher_data = mysqli_fetch_assoc($get_teacher_run);

    if (!$teacher_data) {
        // Handle case if the teacher ID is invalid
        $_SESSION['error_sweetalert_displayed'] = true;
        header("location:add-teacher.php");
        exit();
    }
} else {
    // If ID is not passed, redirect to the list view
    header("location:add-teacher.php");
    exit();
}


// Fetch schools from the database
$select_schools = "SELECT * FROM schools WHERE school_status = 1"; // Only fetch active groups
$select_schools_run = mysqli_query($cn, $select_schools);


// Update teacher section
if (isset($_POST['update-teacher-btn'])) {
    $teacher_name = mysqli_real_escape_string($cn, $_POST['teacher_name']);
    $teacher_cnic = mysqli_real_escape_string($cn, $_POST['teacher_cnic']);
    $teacher_mobile = mysqli_real_escape_string($cn, $_POST['teacher_mobile']);
    $teacher_subject = mysqli_real_escape_string($cn, $_POST['teacher_subject']);
    $teacher_school = mysqli_real_escape_string($cn, $_POST['teacher_school']);
    $teacher_dob = mysqli_real_escape_string($cn, $_POST['teacher_dob']);
    $teacher_joining_date = mysqli_real_escape_string($cn, $_POST['teacher_joining_date']);

    // Update the teacher's data
    $update_teacher_qry = "UPDATE teachers 
                           SET teacher_name = '$teacher_name', 
                               teacher_cnic = '$teacher_cnic', 
                               teacher_mobile = '$teacher_mobile', 
                               teacher_dob = '$teacher_dob', 
                               teacher_joining_date = '$teacher_joining_date', 
                               teacher_subject = '$teacher_subject' ,
                               teacher_school_id = '$teacher_school'
                           WHERE teacher_id = '$teacher_id'";

    if (mysqli_query($cn, $update_teacher_qry)) {
        $_SESSION['primary_sweetalert_displayed'] = true;
        header("location:add-teacher.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($cn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Teacher</title>
    <link rel="stylesheet" href="assets/bundles/select2/dist/css/select2.min.css">

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
                                        <h4>Edit Teacher</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" class="form-control" name="teacher_name" value="<?= $teacher_data['teacher_name']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>CNIC</label>
                                                        <input type="text" class="form-control" data-inputmask="'mask':'99999-9999999-9'" placeholder="xxxx-xxxxxxx" name="teacher_cnic" value="<?= $teacher_data['teacher_cnic']; ?>" required>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Joining Date<span class="text-danger">*</span> :</label>
                                                        <input type="date" class="form-control" required="" value="<?= $teacher_data['teacher_joining_date']; ?>" name="teacher_joining_date">
                                                        <div class="invalid-feedback">
                                                            What's the teacher's joining date?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Date of Birth</label>
                                                        <input type="date" class="form-control" required="" value="<?= $teacher_data['teacher_dob']; ?>" name="teacher_dob">
                                                        <div class="invalid-feedback">
                                                            What's the teacher's date of birth?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Mobile</label>
                                                        <input type="text" data-inputmask="'mask':'9999-9999999'" placeholder="xxxx-xxxxxxx" class="form-control" name="teacher_mobile" value="<?= $teacher_data['teacher_mobile']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Subject</label>
                                                        <select class="form-control select2" name="teacher_subject" required>
                                                            <option selected disabled value="">-- Choose Subject --</option>
                                                            <?php
                                                            // Fetch subjects to populate the dropdown
                                                            $select_subject_qry = "SELECT * FROM subjects";
                                                            $select_subject_run = mysqli_query($cn, $select_subject_qry);

                                                            while ($subject_row = mysqli_fetch_assoc($select_subject_run)) {
                                                                $selected = ($subject_row['subject_id'] == $teacher_data['teacher_subject']) ? 'selected' : '';
                                                                echo "<option value='{$subject_row['subject_id']}' $selected>{$subject_row['subject_name']}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>School<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" id='school-select' required="" name="teacher_school">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php
                                                            // Loop through groups and add them as options in the select
                                                            while ($school = mysqli_fetch_assoc($select_schools_run)) {

                                                                $select = ($school['school_id'] == $teacher_data['teacher_school_id']) ? 'selected' : '';
                                                                echo "<option value='" . $school['school_id'] . "' $select>" . $school['school_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Select a school.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                            </div>



                                            <div class="form-group text-right">
                                                <button type="submit" name="update-teacher-btn" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
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
<!-- SweetAlert Script -->
<?php if (!empty($displayprimarySweetAlert)): ?>
    <script>
        $(document).ready(function() {
            swal({
                title: "primary",
                text: "Teacher updated primaryfully.",
                icon: "primary",
                button: "OK"
            });
        });
    </script>
<?php endif; ?>