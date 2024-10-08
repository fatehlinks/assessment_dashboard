<?php include('auth.php'); ?>
<?php
//Set a session variable to trigger the SweetAlert
if (!empty($_SESSION['success_sweetalert_displayed'])) {
    $displaySuccessSweetAlert = true;
    unset($_SESSION['success_sweetalert_displayed']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Groups</title>
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
                                        <h4><i data-feather="eye"></i> All Groups</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Category</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $select_group_data = "SELECT * FROM groups";
                                                    $select_group_data_run = mysqli_query($cn, $select_group_data);
                                                    while ($row = mysqli_fetch_assoc($select_group_data_run)) {
                                                        $group_id = $row['group_id'];
                                                        $group_name = $row['group_name'];
                                                        $group_category = $row['group_category'];


                                                        $group_status = $row['group_status'];
                                                        if ($group_status == 1) {
                                                            $group_status = "<span class='badge badge-success'>Active</span>";
                                                        } else {
                                                            $group_status = "<span class='badge badge-warning'>Inactive</span>";
                                                        }

                                                    ?>
                                                        <tr>
                                                            <td><?= $group_name; ?></td>
                                                            <td><?= $group_category; ?></td>
                                                            <td><?= $group_status; ?></td>
                                                            <td>
                                                                <div class="dropdown form-control-sm">
                                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                                                        Action
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="group-active.php?id=<?= $group_id; ?>"><i class='fa fa-check-circle'></i> Active</a>
                                                                        <a class="dropdown-item" href="group-inactive.php?id=<?= $group_id; ?>"><i class='fa fa-times-circle'></i> Inactive</a>
                                                                        <a class="dropdown-item" href="edit-group.php?id=<?= $group_id; ?>"><i class='fa fa-edit'></i> Edit </a>
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