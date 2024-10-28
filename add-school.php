<?php include('auth.php'); ?>
<?php
//Set a session variable to trigger the SweetAlert
if (!empty($_SESSION['primary_sweetalert_displayed'])) {
    $displayprimarySweetAlert = true;
    unset($_SESSION['primary_sweetalert_displayed']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>School school</title>

    <?php include_once('include/html-sources.html'); ?>
    <link rel="stylesheet" href="assets/bundles/select2/dist/css/select2.min.css">



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
                                    <form class="needs-validation" novalidate="" method="post" action="insert-school.php">
                                        <div class="card-header">
                                            <h4><i data-feather="plus"></i> Add school</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-school">
                                                        <label>school:</label>
                                                        <input type="text" placeholder="Enter here..." class="form-control" required="" name="school_name">
                                                        <div class="invalid-feedback">
                                                            Enter school Name...!
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                                <div class="col-md-6">
                                                    <div class="d-grid pt-2">
                                                        <label></label>
                                                        <button type="submit" class="btn btn-primary w-75 mt-4" name='add-school'><i class='fa fas fa-plus'></i> Save & Submit</button>
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
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $select_school_data = "SELECT * FROM schools";
                                                    $select_school_data_run = mysqli_query($cn, $select_school_data);
                                                    while ($row = mysqli_fetch_assoc($select_school_data_run)) {
                                                        $school_id = $row['school_id'];
                                                        $school_name = $row['school_name'];


                                                        $school_status = $row['school_status'];
                                                        if ($school_status == 1) {
                                                            $school_status = "<span class='badge badge-primary'>Active</span>";
                                                        } else {
                                                            $school_status = "<span class='badge badge-warning'>Inactive</span>";
                                                        }

                                                    ?>
                                                        <tr>
                                                            <td><?= $school_name; ?></td>
                                                            <td><?= $school_status; ?></td>
                                                            <td>
                                                                <div class="dropdown form-control-sm">
                                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                                                        Action
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="school-active.php?id=<?= $school_id; ?>"><i class='fa fa-check-circle'></i> Active</a>
                                                                        <a class="dropdown-item" href="school-inactive.php?id=<?= $school_id; ?>"><i class='fa fa-times-circle'></i> Inactive</a>
                                                                        <a class="dropdown-item" href="edit-school.php?id=<?= $school_id; ?>"><i class='fa fa-edit'></i> Edit </a>
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
                text: "Operation Successfully completed.",
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