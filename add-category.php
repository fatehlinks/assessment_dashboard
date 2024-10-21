<?php include('auth.php'); ?>
<?php
// Set a session variable to trigger the SweetAlert
if (!empty($_SESSION['primary_sweetalert_displayed'])) {
    $displayprimarySweetAlert = true;
    unset($_SESSION['primary_sweetalert_displayed']);
}

$select_groups = "SELECT * FROM groups WHERE group_status = 1"; // Only fetch active groups
$select_groups_run = mysqli_query($cn, $select_groups);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Category</title>
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
                                    <form class="needs-validation" novalidate="" method="post" action="insert-category.php">
                                        <div class="card-header">
                                            <h4><i data-feather="plus"></i> Add Category</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Name<span class="text-danger">*</span> :</label>
                                                        <input type="text" placeholder="Enter here..." class="form-control" required="" name="category_name">
                                                        <div class="invalid-feedback">
                                                            What's your category name?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Group<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" required="" name="category_group">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php
                                                            // Loop through groups and add them as options in the select
                                                            while ($group = mysqli_fetch_assoc($select_groups_run)) {
                                                                echo "<option value='" . $group['group_id'] . "'>" . $group['group_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Choose group
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->

                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary" name='add-category'><i class='fa fas fa-plus'></i> Save & Submit</button>
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
                                                        <th>Group</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Modified query to join the 'category' and 'groups' tables and fetch group name instead of group_id
                                                    $select_category_data = "SELECT category.category_id, category.category_name, groups.group_name, category.category_status 
                                                                             FROM category 
                                                                             JOIN groups ON category.group_id = groups.group_id 
                                                                             WHERE category.category_status != -1";
                                                    $select_category_data_run = mysqli_query($cn, $select_category_data);
                                                    while ($row = mysqli_fetch_assoc($select_category_data_run)) {
                                                        $category_id = $row['category_id'];
                                                        $category_name = $row['category_name'];
                                                        $group_name = $row['group_name']; // Fetch the group name
                                                        $category_status = $row['category_status'];

                                                        // Define status label
                                                        if ($category_status == 1) {
                                                            $category_status = "<span class='badge badge-primary'>Active</span>";
                                                        } else {
                                                            $category_status = "<span class='badge badge-warning'>Inactive</span>";
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?= $category_name; ?></td>
                                                            <td><?= $group_name; ?></td> <!-- Display group name here -->
                                                            <td><?= $category_status; ?></td>
                                                            <td>
                                                                <div class="dropdown form-control-sm">
                                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                                                        Action
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="category-active.php?id=<?= $category_id; ?>"><i class='fa fa-check-circle'></i> Active</a>
                                                                        <a class="dropdown-item" href="category-inactive.php?id=<?= $category_id; ?>"><i class='fa fa-times-circle'></i> Inactive</a>
                                                                        <a class="dropdown-item" href="edit-category.php?id=<?= $category_id; ?>"><i class='fa fa-edit'></i> Edit </a>
                                                                        <a class="dropdown-item" href="delete-category.php?id=<?= $category_id; ?>"><i class='fa fa-trash'></i> Delete</a>
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
<!-- Page Specific JS File -->
<script src="assets/js/page/forms-advanced-forms.js"></script>

<?php if (!empty($displayprimarySweetAlert)): ?>
    <script>
        $(document).ready(function() {
            swal({
                title: "Congrats",
                text: "Operation primaryfully completed.",
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
                text: "<?= $_SESSION['error_message']; ?>",
                icon: "error",
                button: "OK"
            });
        });
    </script>
    <?php unset($_SESSION['error_sweetalert_displayed']); ?>
<?php endif; ?>