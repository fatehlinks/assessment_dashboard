<?php include('auth.php'); ?>

<?php

// Set session variables for SweetAlert
if (!empty($_SESSION['success_sweetalert_displayed'])) {
    $displaySuccessSweetAlert = true;
    unset($_SESSION['success_sweetalert_displayed']);
}

// Check if the ID is set in the query string
if (isset($_GET['id'])) {
    $subject_id = mysqli_real_escape_string($cn, $_GET['id']);

    // Fetch the current subject data
    $select_subject_qry = "SELECT * FROM subjects WHERE subject_id = '$subject_id'";
    $select_subject_qry_run = mysqli_query($cn, $select_subject_qry);

    if (mysqli_num_rows($select_subject_qry_run) > 0) {
        $subject_data = mysqli_fetch_assoc($select_subject_qry_run);
        $subject_name = $subject_data['subject_name'];
        $subject_grade = $subject_data['subject_grade'];
    } else {
        // If the subject does not exist, redirect back
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = "Invalid subject ID.";
        header("location:add-subject.php");
        exit();
    }
}

// Update subject section
if (isset($_POST['update-subject'])) {
    $subject_name = mysqli_real_escape_string($cn, $_POST['subject_name']);
    $subject_grade = mysqli_real_escape_string($cn, $_POST['subject_grade']);

    // Update query
    $update_subject_qry = "UPDATE subjects SET subject_name = '$subject_name', subject_grade = '$subject_grade' WHERE subject_id = '$subject_id'";

    if (mysqli_query($cn, $update_subject_qry)) {
        $_SESSION['success_sweetalert_displayed'] = true;
        header("location:add-subject.php");
        exit();
    } else {
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = "Error updating record: " . mysqli_error($cn);
        header("location:" . $_SERVER['PHP_SELF'] . "?id=" . $subject_id); // Redirect to same page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Subject</title>
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
                                    <form class="needs-validation" novalidate="" method="post" action="">
                                        <div class="card-header">
                                            <h4><i data-feather="edit"></i> Edit Subject</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Name:</label>
                                                        <input type="text" placeholder="Enter here..." class="form-control" required="" name="subject_name" value="<?= htmlspecialchars($subject_name); ?>">
                                                        <div class="invalid-feedback">
                                                            Please enter a subject name.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Grade:</label>
                                                        <select class="form-control select2" required="" name="subject_grade">
                                                            <option disabled value="">-- Choose --</option>
                                                            <?php for ($i = 1; $i <= 16; $i++): ?>
                                                                <option value="<?= $i; ?>" <?= $i == $subject_grade ? 'selected' : ''; ?>><?= $i; ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please select a grade.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary" name='update-subject'><i class='fa fas fa-save'></i> Update</button>
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

<?php if (!empty($displaySuccessSweetAlert)): ?>
    <script>
        $(document).ready(function() {
            swal({
                title: "Success",
                text: "Subject updated successfully.",
                icon: "success",
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