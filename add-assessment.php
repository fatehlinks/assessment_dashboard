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

// Fetch subjects from the database
include('config.php'); // Ensure you have the connection file included
$query = "SELECT subject_id, subject_name FROM subjects WHERE subject_status = 1";
$subjectsResult = mysqli_query($cn, $query);


// Fetch schools from the database
$select_schools = "SELECT * FROM schools JOIN admin ON schools.school_id = admin.admin_role WHERE school_status = 1"; // Only fetch active groups
$select_schools_run = mysqli_query($cn, $select_schools);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Assessment</title>
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
                                    <form class="needs-validation" novalidate="" method="post" action="insert-assessment.php">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center w-100">
                                                <h4 class="mb-0"><i data-feather="plus"></i> Add Assessment</h4>

                                                <!-- Assessment Last Id -->
                                                <?php
                                                $sql = "SELECT assessment_id FROM assessments ORDER BY assessment_id DESC LIMIT 1";
                                                $result = $cn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $last_assessment_id = (int)$row['assessment_id']; // Cast to an integer to ensure it's numeric
                                                } else {
                                                    $last_assessment_id = 0; // If no records exist, start from 0
                                                }
                                                ?>
                                                <span class='badge badge-warning small'>Assessment No. : <?= $last_assessment_id + 1 ?></span>

                                            </div>


                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Assessment Date<span class="text-danger">*</span> :</label>
                                                        <input type="date" class="form-control" required="" name="assessmt_date">
                                                        <div class="invalid-feedback">
                                                            Please provide an assessment date.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Grade<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" required="" name="assessmt_grade">
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
                                                            Please select a grade.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Subject<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" required="" name="teacher_subject">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php
                                                            // Loop through the subjects and populate the dropdown
                                                            if (mysqli_num_rows($subjectsResult) > 0) {
                                                                while ($row = mysqli_fetch_assoc($subjectsResult)) {
                                                                    echo "<option value='" . $row['subject_id'] . "'>" . $row['subject_name'] . "</option>";
                                                                }
                                                            } else {
                                                                echo "<option disabled>No subjects available</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Choose the teacher's subject.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Section<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" required="" name="assessmt_section">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <option>A</option>
                                                            <option>B</option>
                                                            <option>C</option>
                                                            <option>D</option>
                                                            <option>E</option>
                                                            <option>F</option>
                                                            <option>G</option>
                                                            <option>H</option>
                                                            <option>I</option>
                                                            <option>J</option>
                                                            <option>K</option>
                                                            <option>L</option>
                                                            <option>M</option>
                                                            <option>N</option>
                                                            <option>O</option>
                                                            <option>P</option>
                                                            <option>Q</option>
                                                            <option>R</option>
                                                            <option>S</option>
                                                            <option>T</option>
                                                            <option>U</option>
                                                            <option>V</option>
                                                            <option>W</option>
                                                            <option>X</option>
                                                            <option>Y</option>
                                                            <option>Z</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please select a section.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Group<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" id="group-select" required="" name="assessmt_group">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php
                                                            // Initialize an array to track unique group names
                                                            $uniqueGroupNames = [];

                                                            // Iterate through the groups
                                                            foreach ($groups as $group):
                                                                // Check if the group name is already in the array
                                                                if (!in_array($group['group_name'], $uniqueGroupNames)):
                                                                    // If it's not, add it to the array and display the option
                                                                    $uniqueGroupNames[] = $group['group_name'];
                                                            ?>
                                                                    <option value="<?= $group['group_id']; ?>"><?= $group['group_name']; ?></option>
                                                            <?php
                                                                endif;
                                                            endforeach;
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please select a group.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Group Category:</label>
                                                        <select id="group-category" class="form-control select2" name="assessmt_group_category" required>
                                                            <option selected disabled>-- Choose --</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please select a group category.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->

                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Number of Students<span class="text-danger">*</span> :</label>
                                                        <input type="number" min="0" placeholder="Enter here..." class="form-control" required="" name="assessmt_number_of_students" readonly>
                                                        <div class="invalid-feedback">
                                                            Please provide the number of students.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Total Marks<span class="text-danger">*</span> :</label>
                                                        <input type="number" min="0" placeholder="Enter here..." class="form-control" required="" name="assessmt_total_marks">
                                                        <div class="invalid-feedback">
                                                            Please provide the total marks.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Assessment Deadline<span class="text-danger">*</span> :</label>
                                                        <input type="date" class="form-control" required="" name="assessment_deadline">
                                                        <div class="invalid-feedback">
                                                            Please provide an assessment deadline.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->



                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>School<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" id='school-select' required="" name="assessment_school">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php
                                                            // Loop through groups and add them as options in the select
                                                            while ($school = mysqli_fetch_assoc($select_schools_run)) {

                                                                echo "<option value='" . $school['school_id'] . "' >" . $school['school_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Select a school.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                            </div> <!-- /row -->
                                        </div>

                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary" name='add-assessment-btn'><i class='fa fas fa-plus'></i> Save & Submit</button>
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

<!-- masking -->
<script src="./assets/js/masking/jquery.inputmask.bundle.js"></script>
<script>
    $(":input").inputmask();
</script>



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