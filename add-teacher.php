<?php include('auth.php'); ?>
<?php
//Set a session variable to trigger the SweetAlert
if (!empty($_SESSION['success_sweetalert_displayed'])) {
    $displaySuccessSweetAlert = true;
    unset($_SESSION['success_sweetalert_displayed']);
}

// Fetch subjects from the database
include('config.php'); // Ensure you have the connection file included
$query = "SELECT subject_id, subject_name FROM subjects";
$subjectsResult = mysqli_query($cn, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Teacher</title>
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
                                                        <label>Name:</label>
                                                        <input type="text" placeholder="Enter here..." onkeyup="this.value = this.value.toUpperCase();" class="form-control" required="" name="teacher_name">
                                                        <div class="invalid-feedback">
                                                            What's the teacher's name?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>CNIC</label>
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
                                                        <label>Mobile: </label>
                                                        <input type="text" data-inputmask="'mask':'9999-9999999'" placeholder="xxxx-xxxxxxx" class="form-control" required="" name="teacher_mobile">
                                                        <div class="invalid-feedback">
                                                            Enter the teacher's mobile number.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Subject:</label>
                                                        <select class="form-control select" required="" name="teacher_subject">
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