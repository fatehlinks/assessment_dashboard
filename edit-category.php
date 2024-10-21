<?php include('auth.php'); ?>

<?php
// Fetch the category ID from the URL
if (isset($_GET['id'])) {
    $category_id = mysqli_real_escape_string($cn, $_GET['id']);

    // Fetch category details
    $select_category = "SELECT * FROM category WHERE category_id = '$category_id'";
    $select_category_run = mysqli_query($cn, $select_category);

    if (mysqli_num_rows($select_category_run) > 0) {
        $category_data = mysqli_fetch_assoc($select_category_run);
        $current_category_name = $category_data['category_name'];
        $current_group_id = $category_data['group_id'];
    } else {
        // Redirect back if the category is not found
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = 'Category not found.';
        header("Location: add-category.php");
        exit();
    }
}

// Update category details
if (isset($_POST['update-category'])) {
    $category_name = mysqli_real_escape_string($cn, $_POST['category_name']);
    $category_group = $_POST['category_group']; // Group ID

    // Update query
    $update_category_qry = "UPDATE category SET category_name = '$category_name', group_id = '$category_group' WHERE category_id = '$category_id'";
    $update_category_run = mysqli_query($cn, $update_category_qry);

    if ($update_category_run) {
        $_SESSION['primary_sweetalert_displayed'] = true;
        header("Location: add-category.php");
        exit();
    } else {
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = 'Error updating category. Please try again.';
        header("Location: edit-category.php?id=$category_id");
    }
}

// Fetch active groups for the select dropdown
$select_groups = "SELECT * FROM groups WHERE group_status = 1";
$select_groups_run = mysqli_query($cn, $select_groups);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Category</title>
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
                                            <h4><i data-feather="edit"></i> Edit Category</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Name<span class="text-danger">*</span> :</label>
                                                        <input type="text" class="form-control" value="<?= $current_category_name; ?>" required="" name="category_name">
                                                        <div class="invalid-feedback">
                                                            What's the category name?
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Group<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" required="" name="category_group">
                                                            <option disabled value="">-- Choose --</option>
                                                            <?php
                                                            while ($group = mysqli_fetch_assoc($select_groups_run)) {
                                                                $selected = ($group['group_id'] == $current_group_id) ? "selected" : "";
                                                                echo "<option value='" . $group['group_id'] . "' $selected>" . $group['group_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Choose group
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary" name="update-category"><i class='fa fas fa-save'></i> Save Changes</button>
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

<!-- SweetAlert for success or error -->
<?php if (!empty($_SESSION['primary_sweetalert_displayed'])): ?>
    <script>
        $(document).ready(function() {
            swal({
                title: "Success",
                text: "Category updated successfully!",
                icon: "success",
                button: "OK"
            });
        });
    </script>
    <?php unset($_SESSION['primary_sweetalert_displayed']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['error_sweetalert_displayed'])): ?>
    <script>
        $(document).ready(function() {
            swal({
                title: "Error",
                text: "<?= $_SESSION['error_message']; ?>",
                icon: "error",
                button: "OK"
            });
        });
    </script>
    <?php unset($_SESSION['error_sweetalert_displayed']); ?>
<?php endif; ?>