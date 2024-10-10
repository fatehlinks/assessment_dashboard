<?php include('auth.php'); ?>
<?php
// Set a session variable to trigger the SweetAlert
if (!empty($_SESSION['success_sweetalert_displayed'])) {
    $displaySuccessSweetAlert = true;
    unset($_SESSION['success_sweetalert_displayed']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Assessment</title>
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
                                        <h4><i data-feather="eye"></i> All Assessments</h4>

                                    </div>
                                    <div class="card-body p-2">
                                        <div class="table-responsive">
                                            <table class="table small table-striped table-hover" style='font-size:10px' id="tableExport" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Ass#</th>
                                                        <th>Date</th>
                                                        <th>Grade</th>
                                                        <th>Subject</th>
                                                        <th>Group</th>
                                                        <th>Category</th>
                                                        <th>Section</th>
                                                        <th>Students</th>
                                                        <th>Marks</th>
                                                        <th>Deadline</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Fetch assessment data from the database
                                                    $select_assessment_data = "
                                                        SELECT 
                                                        a.assessment_id, 
                                                        a.assessment_date, 
                                                        a.assessment_grade, 
                                                        a.assessment_section, 
                                                        a.assessment_number_of_students, 
                                                        a.assessment_total_marks, 
                                                        a.assessment_deadline, 
                                                        a.assessment_status,
                                                        g.group_id, 
                                                        g.group_name, 
                                                        g.group_category, 
                                                        g.group_status, 
                                                        s.subject_id, 
                                                        s.subject_name, 
                                                        s.subject_grade, 
                                                        s.subject_status
                                                        FROM 
                                                        assessments a
                                                        JOIN 
                                                        groups g ON a.assessment_group = g.group_id
                                                        JOIN 
                                                        subjects s ON a.assessment_subject = s.subject_id
                                                        WHERE 
                                                        a.assessment_status != -1;
                                                        ";

                                                    $select_assessment_data_run = mysqli_query($cn, $select_assessment_data);

                                                    while ($row = mysqli_fetch_assoc($select_assessment_data_run)) {
                                                        $assessment_id = $row['assessment_id'];
                                                        $assessment_date = date("d-M-Y", strtotime($row['assessment_date']));
                                                        $grade = $row['assessment_grade'];
                                                        $subject_name = $row['subject_name'];
                                                        $group_name = $row['group_name'];
                                                        $group_category = $row['group_category'];
                                                        $section = $row['assessment_section'];
                                                        $number_of_students = $row['assessment_number_of_students'];
                                                        $total_marks = $row['assessment_total_marks'];
                                                        $assessment_deadline = date("d-M-Y", strtotime($row['assessment_deadline']));
                                                        $assessment_status = $row['assessment_status'];

                                                        if ($assessment_status == 2) {
                                                            $assessment_status = "<b class='text-success'>Completed</b>";
                                                        } else {
                                                            $assessment_status = "<b class='text-warning'>Continue</b>";
                                                        }

                                                    ?>
                                                        <tr>
                                                            <td><strong class=""><?= $assessment_id ?></strong></td>
                                                            <td><?= $assessment_date; ?></td>
                                                            <td><?= $grade; ?></td>
                                                            <td><?= $subject_name; ?></td>
                                                            <td><?= $group_name; ?></td>
                                                            <td><?= $group_category; ?></td>
                                                            <td><?= $section; ?></td>
                                                            <td><?= $number_of_students; ?></td>
                                                            <td><?= $total_marks; ?></td>
                                                            <td><?= $assessment_deadline; ?></td>
                                                            <td><?= $assessment_status; ?></td>
                                                            <td>
                                                                <div class="dropdown form-control-sm">
                                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                                                                        Action
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="complete-assessment.php?id=<?= $assessment_id; ?>"><i class='fa fa-check-circle'></i> Completed</a>
                                                                        <a class="dropdown-item" href="delete-assessment.php?id=<?= $assessment_id; ?>"><i class='fa fa-trash'></i> Delete</a>
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

<!-- SweetAlert Script -->
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