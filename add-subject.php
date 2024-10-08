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
    <title>Add Subject</title>

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
                                    <form class="needs-validation" novalidate="" method="post" action="insert-subject.php">
                                        <div class="card-header">
                                            <h4><i data-feather="plus"></i> Add Subject</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Name<span class="text-danger">*</span> :</label>
                                                        <input type="text" placeholder="Enter here..." class="form-control" required="" name="subject_name">
                                                        <div class="invalid-feedback">
                                                            What's your subject name?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Grade<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" required="" name="subject_grade">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <option value='1'>1</option>
                                                            <option value='2'>2</option>
                                                            <option value='3'>3</option>
                                                            <option value='4'>4</option>
                                                            <option value='5'>5</option>
                                                            <option value='6'>6</option>
                                                            <option value='7'>7</option>
                                                            <option value='8'>8</option>
                                                            <option value='9'>9</option>
                                                            <option value='10'>10</option>
                                                            <option value='11'>11</option>
                                                            <option value='12'>12</option>
                                                            <option value='13'>13</option>
                                                            <option value='14'>14</option>
                                                            <option value='15'>15</option>
                                                            <option value='16'>16</option>

                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Choose profile role
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->


                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary" name='add-subject'><i class='fa fas fa-plus'></i> Save & Submit</button>
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
                                    <div class="card-header">
                                        <h4><i data-feather="eye" class="me-2"></i> All Subjects</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Grade</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $select_subject_data = "SELECT * FROM subjects";
                                                    $select_subject_data_run = mysqli_query($cn, $select_subject_data);
                                                    while ($row = mysqli_fetch_assoc($select_subject_data_run)) {
                                                        $subject_id = $row['subject_id'];
                                                        $subject_name = $row['subject_name'];
                                                        $subject_grade = $row['subject_grade'];


                                                        $subject_status = $row['subject_status'];
                                                        if ($subject_status == 1) {
                                                            $subject_status = "<span class='badge badge-success'>Active</span>";
                                                        } else {
                                                            $subject_status = "<span class='badge badge-warning'>Inactive</span>";
                                                        }

                                                    ?>
                                                        <tr>
                                                            <td><?= $subject_name; ?></td>
                                                            <td><?= $subject_grade; ?></td>
                                                            <td><?= $subject_status; ?></td>
                                                            <td>
                                                                <div class="dropdown form-control-sm">
                                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                                                        Action
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="subject-active.php?id=<?= $subject_id; ?>"><i class='fa fa-check-circle'></i> Active</a>
                                                                        <a class="dropdown-item" href="subject-inactive.php?id=<?= $subject_id; ?>"><i class='fa fa-times-circle'></i> Inactive</a>
                                                                        <a class="dropdown-item" href="edit-subject.php?id=<?= $subject_id; ?>"><i class='fa fa-edit'></i> Edit </a>
                                                                        <a class="dropdown-item" href="delete-subject.php?id=<?= $subject_id; ?>"><i class='fa fa-trash'></i> Delete</a>
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