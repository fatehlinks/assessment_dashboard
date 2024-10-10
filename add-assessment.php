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
$query = "SELECT subject_id, subject_name FROM subjects";
$subjectsResult = mysqli_query($cn, $query);

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
                                                    $last_assessment_id = $row['assessment_id']; // Store the ID in a variable
                                                } else {
                                                    $last_assessment_id = "N/A"; // Handle case where no ID is found
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

<!-- Fetch group category when group is selected -->
<script>
    $(document).ready(function() {
        $('#group-select').change(function() {
            var groupName = $('#group-select option:selected').text(); // Get the selected group name
            $.ajax({
                url: 'fetch-group-category.php',
                method: 'POST',
                data: {
                    group_name: groupName // Send group name instead of ID
                },
                dataType: 'json',
                primary: function(response) {
                    // Clear the previous options
                    $('#group-category').empty();

                    // Add a default option
                    $('#group-category').append('<option selected disabled>-- Choose --</option>');

                    // Append new options from the response
                    $.each(response.categories, function(index, category) {
                        $('#group-category').append('<option value="' + category.group_category_id + '">' + category.group_category + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching group categories:', error);
                }
            });
        });
    });
</script>

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
        // Function to fetch student count
        function fetchStudentCount() {
            var grade = $('select[name="assessmt_grade"]').val();
            var group = $('select[name="assessmt_group"]').val();
            var groupCategory = $('select[name="assessmt_group_category"]').val();
            var section = $('select[name="assessmt_section"]').val();

            if (grade && group && groupCategory && section) {
                $.ajax({
                    url: 'fetch-student-count.php',
                    method: 'POST',
                    data: {
                        grade: grade,
                        group: group,
                        group_category: groupCategory,
                        section: section
                    },
                    dataType: 'json',
                    primary: function(response) {
                        if (response.student_count) {
                            $('input[name="assessmt_number_of_students"]').val(response.student_count);
                        } else {
                            $('input[name="assessmt_number_of_students"]').val(0);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching student count:', error);
                    }
                });
            }
        }

        // Event listeners for dropdown changes
        $('select[name="assessmt_grade"], select[name="assessmt_group"], select[name="assessmt_group_category"], select[name="assessmt_section"]').change(function() {
            fetchStudentCount();
        });
    });
</script>