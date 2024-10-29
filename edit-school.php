<?php include('user-auth.php'); ?>

<?php
// Get school ID from query string
if (isset($_GET['id'])) {
    $school_id = mysqli_real_escape_string($cn, $_GET['id']);

    // Fetch the school's current data
    $get_school_qry = "SELECT * FROM schools WHERE school_id = '$school_id'";
    $get_school_run = mysqli_query($cn, $get_school_qry);
    $school_data = mysqli_fetch_assoc($get_school_run);

    if (!$school_data) {
        // Handle case if the school ID is invalid
        $_SESSION['error_sweetalert_displayed'] = true;
        header("location:add-school.php");
        exit();
    }
} else {
    // If ID is not passed, redirect to the list view
    header("location:add-school.php");
    exit();
}

// Update school section
if (isset($_POST['update-school-btn'])) {
    $school_name = mysqli_real_escape_string($cn, $_POST['school_name']);

    // Validate inputs
    if (empty($school_name)) {
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = "All fields are required.";
    } else {
        // Update the school's data
        $update_school_qry = "UPDATE schools 
                              SET school_name = '$school_name'                                  
                              WHERE school_id = '$school_id'";

        if (mysqli_query($cn, $update_school_qry)) {
            $_SESSION['primary_sweetalert_displayed'] = true;
            header("location:add-school.php");
            exit();
        } else {
            $_SESSION['error_sweetalert_displayed'] = true;
            $_SESSION['error_message'] = "Error updating school: " . mysqli_error($cn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit school</title>

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
                                    <form class="needs-validation" novalidate="" method="post" action="">
                                        <div class="card-header">
                                            <h4><i data-feather="edit"></i> Edit school</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-school">
                                                        <label>school:</label>
                                                        <input type="text" placeholder="Enter here..." class="form-control" required="" name="school_name" value="<?= htmlspecialchars($school_data['school_name']); ?>">
                                                        <div class="invalid-feedback">
                                                            Enter school Name...!
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                                <div class="col-md-6">
                                                    <div class="d-grid pt-2">
                                                        <button type="submit" class="btn btn-primary w-75 mt-4" name='update-school-btn'><i class='fa fas fa-save'></i> Save & Update</button>

                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->
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
<!-- Page Specific JS File -->
<script src="assets/js/page/forms-advanced-forms.js"></script>

<!-- SweetAlert Script -->
<?php if (!empty($displayprimarySweetAlert)): ?>
    <script>
        $(document).ready(function() {
            swal({
                title: "primary",
                text: "School Updated Successfully.",
                icon: "primary",
                button: "OK"
            });
        });
    </script>
<?php endif; ?>

<?php if (!empty($_SESSION['error_sweetalert_displayed'])): ?>
    <script>
        $(document).ready(function() {
            swal({
                title: "Error",
                text: "<?= htmlspecialchars($_SESSION['error_message']); ?>",
                icon: "error",
                button: "OK"
            });
        });
    </script>
    <?php unset($_SESSION['error_sweetalert_displayed']); ?>
<?php endif; ?>