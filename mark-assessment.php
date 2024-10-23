    <?php include("auth.php"); ?>

    <?php
    // Fetch assessment data based on ID
    if (isset($_GET['id'])) {
        $get_assessment_id = mysqli_real_escape_string($cn, $_GET['id']);

        // Fetch assessment details
        $select_assessment_data = "SELECT assessment_id, assessment_grade, assessment_section, assessment_group, assessment_group_category, assessment_total_marks 
                           FROM assessments 
                           WHERE assessment_id = '$get_assessment_id'";

        // Execute the query and check for errors
        $assessment_result = mysqli_query($cn, $select_assessment_data);
        if (!$assessment_result) {
            die('SQL Error: ' . mysqli_error($cn)); // Output SQL error if the query fails
        }

        // Check if rows are returned
        if (mysqli_num_rows($assessment_result) > 0) {
            $assessment = mysqli_fetch_assoc($assessment_result);
        } else {
            die("No assessment found with the given ID.");
        }

        $total_marks =   $assessment['assessment_total_marks'];

        // Check if the total marks field exists
        if (!isset($assessment['assessment_total_marks'])) {
            die("The total marks field is missing in the assessment data.");
        }

        // Fetch students that match the assessment criteria
        $student_query = "SELECT * FROM students 
            WHERE 
            student_grade = '" . $assessment['assessment_grade'] . "' 
            AND student_section = '" . $assessment['assessment_section'] . "' 
            AND student_group = '" . $assessment['assessment_group'] . "' 
            AND student_group_category = '" . $assessment['assessment_group_category'] . "' 
            AND student_status = 1;";

        $student_result = mysqli_query($cn, $student_query);
        if (!$student_result) {
            die('SQL Error: ' . mysqli_error($cn)); // Output SQL error if the query fails
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Mark Assessment</title>
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
                                        <div class="card-header w-100 d-flex align-items-center justify-content-between">
                                            <h4><i data-feather="edit"></i> Assessment Marking</h4>
                                            <span class='badge badge-warning small'>Assessment No. : <?= htmlspecialchars($assessment['assessment_id']); ?></span>
                                        </div>
                                        <div class="card-body">
                                            <form action="insert-marks.php" method="POST">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Reg ID</th>
                                                                <th>Name</th>
                                                                <th>Father Name</th>
                                                                <th>Obtain Marks</th>
                                                                <th>Total Marks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            // Loop through students and display them
                                                            if (mysqli_num_rows($student_result) > 0) {
                                                                while ($student = mysqli_fetch_assoc($student_result)) {


                                                            ?>
                                                                    <!-- student Id and Assessment Id hidden to store in database -->
                                                                    <input type="hidden" class="form-control form-control-sm" name="assessment_id[]" value="<?= htmlspecialchars($assessment['assessment_id']); ?>" readonly>
                                                                    <input type="hidden" class="form-control form-control-sm" name="student_id[]" value="<?= htmlspecialchars($student['student_id']); ?>" readonly>

                                                                    <tr>
                                                                        <td>
                                                                            <?= $student['student_reg_id'] ?>
                                                                        </td>
                                                                        <td>
                                                                            <?= $student['student_name'] ?>
                                                                        </td>
                                                                        <td>
                                                                            <?= $student['student_father_name'] ?>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" name="obtain_marks[]" class="form-control form-control-sm" required>
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" class="form-control form-control-sm" value="<?= htmlspecialchars($total_marks); ?>" readonly>
                                                                        </td>
                                                                    </tr>
                                                            <?php
                                                                }
                                                            } else {
                                                                echo "<tr><td colspan='4'>No students found.</td></tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Submit Marks</button>
                            </div>
                        </div>
                        </form>
                    </section>
                </div>

                <?php include_once('include/footer.php'); ?>
            </div>
        </div>
    </body>

    </html>

    <?php include_once('include/js-sources.html'); ?>