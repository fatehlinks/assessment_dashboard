<?php include('auth.php'); ?>
<?php
// Set a session variable to trigger the SweetAlert
if (!empty($_SESSION['primary_sweetalert_displayed'])) {
    $displayprimarySweetAlert = true;
    unset($_SESSION['primary_sweetalert_displayed']);
}

// Fetch groups from the database
$groups_query = "SELECT * FROM groups";
$groups_result = mysqli_query($cn, $groups_query);
$groups = mysqli_fetch_all($groups_result, MYSQLI_ASSOC);

// Fetch completed assessments
$assessments_query = "SELECT assessment_id, assessment_date, assessment_grade, assessment_subject, assessment_section, assessment_group, assessment_group_category, assessment_number_of_students, assessment_total_marks, assessment_deadline, assessment_status FROM assessments WHERE assessment_status = 2";
$assessments_result = mysqli_query($cn, $assessments_query);
$assessments = mysqli_fetch_all($assessments_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Filter</title>
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
                            <div class="col-12">
                                <div class="card">
                                    <form class="needs-validation" novalidate method="post" action="">
                                        <div class="card-header">
                                            <h4><i data-feather="filter"></i> Filter Result</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Completed Assessment<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" required name="filter_assessment_id">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php foreach ($assessments as $assessment): ?>
                                                                <option value="<?= $assessment['assessment_id']; ?>">
                                                                    <?= "Assessment " . $assessment['assessment_id']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <div class="invalid-feedback">Please select a completed assessment.</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Grade<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" name="filter_subject_grade">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php for ($i = 1; $i <= 16; $i++): ?>
                                                                <option value='<?= $i; ?>'><?= $i; ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                        <div class="invalid-feedback">Choose profile role</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Section<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" name="filter_assessmt_section">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php foreach (range('A', 'Z') as $letter): ?>
                                                                <option><?= $letter; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <div class="invalid-feedback">Please select a section.</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Group<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" id="group-select" name="filter_assessmt_group">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php foreach ($groups as $group): ?>
                                                                <option value="<?= $group['group_id']; ?>"><?= $group['group_name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <div class="invalid-feedback">Please select a group.</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Group Category:</label>
                                                        <select id="group-category" class="form-control select2" name="filter_assessmt_group_category">
                                                            <option selected disabled>-- Choose --</option>
                                                        </select>
                                                        <div class="invalid-feedback">Please select a group category.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary" name='load-data'> Load Result <i class='fa fa-share'></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <?php
                if (isset($_POST['load-data'])) {
                    // Capture filter inputs
                    $filter_assessment_id = $_POST['filter_assessment_id'];
                    $filter_subject_grade = $_POST['filter_subject_grade'] ?? null;
                    $filter_assessmt_section = $_POST['filter_assessmt_section'] ?? null;
                    $filter_assessmt_group = $_POST['filter_assessmt_group'] ?? null;
                    $filter_assessmt_group_category = $_POST['filter_assessmt_group_category'] ?? null;

                    // Fetch the selected assessment for display
                    $selected_assessment_query = "SELECT * FROM assessments WHERE assessment_id = '$filter_assessment_id'";
                    $selected_assessment_result = mysqli_query($cn, $selected_assessment_query);
                    $selected_assessment = mysqli_fetch_assoc($selected_assessment_result);

                    // Build query dynamically based on available filters
                    $query = "
        SELECT 
            s.student_id,
            s.student_name,
            m.marking_obtained_marks,
            m.marking_total_marks,
            m.marking_student_id
        FROM students s
        LEFT JOIN marking m ON s.student_id = m.marking_student_id 
            AND m.marking_assessment_id = '$filter_assessment_id'
        WHERE m.marking_status = 1"; // Placeholder to append conditions dynamically

                    if ($filter_subject_grade) {
                        $query .= " AND s.student_grade = '$filter_subject_grade'";
                    }
                    if ($filter_assessmt_section) {
                        $query .= " AND s.student_section = '$filter_assessmt_section'";
                    }
                    if ($filter_assessmt_group) {
                        $query .= " AND s.student_group = '$filter_assessmt_group'";
                    }
                    if ($filter_assessmt_group_category) {
                        $query .= " AND s.student_group_category = '$filter_assessmt_group_category'";
                    }

                    $query .= " ORDER BY s.student_name ASC";

                    $result = mysqli_query($cn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        // Display the result in the table
                        echo "
    <section class='section'>
        <div class='section-body'>
            <div class='row'>
                <div class='col-12'>
                    <div class='card'>
                        <div class='card-header w-100 d-flex justify-content-end'>
                            <span class='badge bg-warning text-white'>Assessment: {$selected_assessment['assessment_id']} | Date: {$selected_assessment['assessment_date']}</span>
                        </div>
                        <div class='card-body'>
                            <div class='table-responsive'>
                                <table class='table table-striped table-hover' id='tableExport' style='width:100%;'>
                                    <thead>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Obtained Marks</th>
                                            <th>Total Marks</th>
                                            <th>Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                        // Loop through each student's data and display the marks
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Split both student IDs and obtained marks into arrays
                            $studentIdsArray = explode(',', $row['marking_student_id'] ?? '');
                            $obtainedMarksArray = explode(',', $row['marking_obtained_marks'] ?? '');
                            $totalMarks = $row['marking_total_marks'] ?? 'N/A';

                            // Ensure both arrays have the same length
                            $maxLength = max(count($studentIdsArray), count($obtainedMarksArray));

                            for ($index = 0; $index < $maxLength; $index++) {
                                $studentId = $studentIdsArray[$index] ?? 'N/A';  // Handle missing student ID
                                $obtainedMark = $obtainedMarksArray[$index] ?? 'N/A';  // Handle missing marks
                                $percentage = ($totalMarks > 0) ? ($obtainedMark / $totalMarks) * 100 : 0;


                                // Fetch the correct student name based on student ID
                                $get_student_name_qry = "SELECT student_name FROM students WHERE student_id = $studentId";
                                $get_student_name_qry_run = mysqli_query($cn, $get_student_name_qry);

                                if (mysqli_num_rows($get_student_name_qry_run) > 0) {
                                    while ($get_student_name = mysqli_fetch_assoc($get_student_name_qry_run)) {

                                        $studentName = $get_student_name['student_name'];

                                        echo "<tr>
                        <td>{$studentId}</td>
                        <td>{$studentName}</td>
                        <td>{$obtainedMark}</td>
                        <td>{$totalMarks}</td>
                        <td>{$percentage}%</td>
                      </tr>";
                                    }
                                }
                            }
                        }
                        echo "                      </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>";
                    } else {
                        echo "<p>No matching records found.</p>";
                    }
                }
                ?>




            </div>

            <?php include_once('include/footer.php'); ?>
        </div>
    </div>

</body>

</html>

<?php include_once('include/js-sources.html'); ?>
<script src="assets/js/page/forms-advanced-forms.js"></script>

<!-- Sweet Alert handling -->
<?php if (!empty($displayprimarySweetAlert)): ?>
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
        <?php unset($_SESSION['error_sweetalert_displayed']); ?>
    </script>
<?php endif; ?>


<script>
    $(document).ready(function() {
        $('#group-select').change(function() {
            var groupID = $(this).val(); // Get the selected group ID

            if (groupID) {
                debugger;
                $.post('fetch-group-category.php', {
                    group_id: groupID
                }, function(response) {

                    // Clear previous options
                    $('#group-category').empty();
                    $('#group-category').append('<option selected disabled>-- Choose --</option>');

                    // Check if categories are available in response
                    if (response.categories.length > 0) {
                        // Populate group category options
                        $.each(response.categories, function(index, category) {
                            $('#group-category').append('<option value="' + category.category_id + '">' + category.category_name + '</option>');
                        });
                    } else {
                        $('#group-category').append('<option selected disabled>No categories available</option>');
                    }
                }, );


            } else {
                $('#group-category').empty();
                $('#group-category').append('<option selected disabled>-- Choose --</option>');
            }
        });




        // Function to fetch the student count based on grade, group, category, and section
        function fetchStudentCount() {
            var grade = $('[name="assessmt_grade"]').val();
            var group = $('#group-select').val();
            var groupCategory = $('#group-category').val();
            var section = $('[name="assessmt_section"]').val();

            if (grade && group && groupCategory && section) {
                $.post('fetch-student-count.php', {
                    grade: grade,
                    group: group,
                    group_category: groupCategory,
                    section: section
                }, function(response) {
                    if (response.student_count) {
                        $('[name="assessmt_number_of_students"]').val(response.student_count); // Update the number of students
                    } else {
                        alert('Error: ' + response.error); // Handle errors
                    }
                }, 'json');
            } else {
                $('[name="assessmt_number_of_students"]').val(''); // Clear the field if inputs are incomplete
            }
        }

        // Call the fetch function when any relevant field changes
        $('[name="assessmt_grade"], #group-select, #group-category, [name="assessmt_section"]').change(function() {
            fetchStudentCount();
        });

    });
</script>