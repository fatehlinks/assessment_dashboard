<?php include('auth.php'); ?>

<?php
// Get group ID from query string
if (isset($_GET['id'])) {
    $group_id = mysqli_real_escape_string($cn, $_GET['id']);

    // Fetch the group's current data
    $get_group_qry = "SELECT * FROM groups WHERE group_id = '$group_id'";
    $get_group_run = mysqli_query($cn, $get_group_qry);
    $group_data = mysqli_fetch_assoc($get_group_run);

    if (!$group_data) {
        // Handle case if the group ID is invalid
        $_SESSION['error_sweetalert_displayed'] = true;
        header("location:add-group.php");
        exit();
    }
} else {
    // If ID is not passed, redirect to the list view
    header("location:add-group.php");
    exit();
}

// Update group section
if (isset($_POST['update-group-btn'])) {
    $group_name = mysqli_real_escape_string($cn, $_POST['group_name']);
    $group_category = mysqli_real_escape_string($cn, $_POST['group_category']);

    // Validate inputs
    if (empty($group_name) || empty($group_category)) {
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = "All fields are required.";
    } else {
        // Update the group's data
        $update_group_qry = "UPDATE groups 
                              SET group_name = '$group_name', 
                                  group_category = '$group_category'
                              WHERE group_id = '$group_id'";

        if (mysqli_query($cn, $update_group_qry)) {
            $_SESSION['success_sweetalert_displayed'] = true;
            header("location:add-group.php");
            exit();
        } else {
            $_SESSION['error_sweetalert_displayed'] = true;
            $_SESSION['error_message'] = "Error updating group: " . mysqli_error($cn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Group</title>

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
                                            <h4><i data-feather="edit"></i> Edit Group</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Group:</label>
                                                        <input type="text" placeholder="Enter here..." class="form-control" required="" name="group_name" value="<?= htmlspecialchars($group_data['group_name']); ?>">
                                                        <div class="invalid-feedback">
                                                            Enter Group Name...!
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Group Category:</label>
                                                        <input type="text" placeholder="Enter here..." class="form-control" required="" name="group_category" value="<?= htmlspecialchars($group_data['group_category']); ?>">
                                                        <div class="invalid-feedback">
                                                            What's your Group Category..?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary" name='update-group-btn'><i class='fa fas fa-save'></i> Save & Update</button>
                                            <a href="view-groups.php" class="btn btn-secondary">Cancel</a>
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
<?php if (!empty($displaySuccessSweetAlert)): ?>
    <script>
        $(document).ready(function() {
            swal({
                title: "Success",
                text: "Group updated successfully.",
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