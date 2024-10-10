<?php include('auth.php'); ?>
<?php
// Fetch student details using the student ID
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch student data from the database
    $query = "SELECT * FROM students WHERE student_id = ?";
    $stmt = mysqli_prepare($cn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $student = mysqli_fetch_assoc($result);

    if (!$student) {
        // Handle the case where the student is not found
        echo "Student not found!";
        exit;
    }
} else {
    // Redirect or show an error if student_id is not provided
    echo "No student ID provided!";
    exit;
}

// Fetch groups from the database
$groups_query = "SELECT * FROM groups";
$groups_result = mysqli_query($cn, $groups_query);
$groups = mysqli_fetch_all($groups_result, MYSQLI_ASSOC);
?>


<!-- update query -->

<?php


if (isset($_POST['edit-student-btn'])) {
    // Get the submitted form data
    $student_id = $_POST['student_id'];
    $student_cnic = $_POST['student_cnic'];
    $student_mobile = $_POST['student_mobile'];
    $student_name = strtoupper($_POST['student_name']);
    $student_father_name = strtoupper($_POST['student_father_name']);
    $student_dob = $_POST['student_dob'];
    $student_gender = $_POST['student_gender'];
    $student_address = $_POST['student_address'];
    $student_grade = $_POST['student_grade'];
    $student_section = $_POST['student_section'];
    $student_group = $_POST['student_group'];
    $student_group_category = $_POST['student_group_category'];
    $student_remarks = isset($_POST['student_remarks']) ? $_POST['student_remarks'] : null;

    // SQL query to update the student's data
    $query = "UPDATE students 
              SET 
                  student_cnic = ?, 
                  student_mobile = ?, 
                  student_name = ?, 
                  student_father_name = ?, 
                  student_dob = ?, 
                  student_gender = ?, 
                  student_address = ?, 
                  student_grade = ?, 
                  student_section = ?, 
                  student_group = ?, 
                  student_group_category = ?, 
                  student_remarks = ?
              WHERE student_id = ?";

    // Prepare the statement
    $stmt = mysqli_prepare($cn, $query);

    // Bind the parameters
    mysqli_stmt_bind_param(
        $stmt,
        'ssssssssssssi',
        $student_cnic,
        $student_mobile,
        $student_name,
        $student_father_name,
        $student_dob,
        $student_gender,
        $student_address,
        $student_grade,
        $student_section,
        $student_group,
        $student_group_category,
        $student_remarks,
        $student_id
    );

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // If update was primaryful, redirect to the students page or show a primary message
        $_SESSION['primary_sweetalert_displayed'] = true;
        header('Location: view-students.php');
    } else {
        // If there was an error, show an error message
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = "Failed to update student details!";
        header('Location: edit-student.php?student_id=' . $student_id);
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Student</title>
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
                                            <h4><i data-feather="edit"></i> Edit Student</h4>
                                        </div>
                                        <div class="card-body">
                                            <!-- Hidden field to send the student ID -->
                                            <input type="hidden" name="student_id" value="<?= $student['student_id']; ?>">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Reg ID <span class="text-danger">*</span> :</label>
                                                        <input type="number" min='1' placeholder="Enter here..." class="form-control" required="" name="student_reg_id" value="<?= $student['student_reg_id']; ?>" readonly>
                                                        <div class="invalid-feedback">
                                                            Registration ID is Missing...!
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>CNIC<span class="text-danger">*</span> :</label>
                                                        <input type="text" data-inputmask="'mask':'99999-9999999-9'" placeholder="xxxxx-xxxxxxx-x" class="form-control" required="" name="student_cnic" value="<?= $student['student_cnic']; ?>">
                                                        <div class="invalid-feedback">
                                                            What's your CNIC?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Mobile<span class="text-danger">*</span> : </label>
                                                        <input type="text" data-inputmask="'mask':'9999-9999999'" placeholder="xxxx-xxxxxxx" class="form-control" required="" name="student_mobile" value="<?= $student['student_mobile']; ?>">
                                                        <div class="invalid-feedback">
                                                            Enter your mobile number.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Name<span class="text-danger">*</span> :</label>
                                                        <input type="text" placeholder="Enter here..." onkeyup="this.value = this.value.toUpperCase();" class="form-control" required="" name="student_name" value="<?= $student['student_name']; ?>">
                                                        <div class="invalid-feedback">
                                                            What's your Name?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Father Name<span class="text-danger">*</span> :</label>
                                                        <input type="text" placeholder="Enter here..." onkeyup="this.value = this.value.toUpperCase();" class="form-control" required="" name="student_father_name" value="<?= $student['student_father_name']; ?>">
                                                        <div class="invalid-feedback">
                                                            What's your Father Name?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Date of Birth<span class="text-danger">*</span> :</label>
                                                        <input type="date" class="form-control" required="" name="student_dob" value="<?= $student['student_dob']; ?>">
                                                        <div class="invalid-feedback">
                                                            What's your Date of Birth?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Gender<span class="text-danger">*</span> :</label>
                                                        <select class="form-control" required="" name="student_gender">
                                                            <option disabled value="">-- Choose --</option>
                                                            <option <?= $student['student_gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                                            <option <?= $student['student_gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Choose your Gender....!
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Address<span class="text-danger">*</span> :</label>
                                                        <input type="text" placeholder="Enter here..." class="form-control" required="" name="student_address" value="<?= $student['student_address']; ?>">
                                                        <div class="invalid-feedback">
                                                            What's your Address?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Grade<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" required="" name="student_grade">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                <option value='<?= $i; ?>' <?= $student['student_grade'] == $i ? 'selected' : ''; ?>><?= $i; ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Choose Grade
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Section<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" required="" name="student_section">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php
                                                            // Generate options from A to Z
                                                            foreach (range('A', 'Z') as $letter) {
                                                                // Check if the current letter is the student's section and select it if it is
                                                                $selected = ($student['student_section'] == $letter) ? 'selected' : '';
                                                                echo "<option $selected>$letter</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Choose profile role
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <!-- Group Dropdown -->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Group<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" id="group-select" required="" name="student_group">
                                                            <option disabled value="">-- Choose --</option>
                                                            <?php
                                                            // Initialize an array to track unique group names
                                                            $uniqueGroupNames = [];

                                                            // Iterate through the groups
                                                            foreach ($groups as $group):
                                                                // Check if the group name is already in the array
                                                                if (!in_array($group['group_name'], $uniqueGroupNames)):
                                                                    $uniqueGroupNames[] = $group['group_name'];
                                                                    $selected = ($group['group_id'] == $student['student_group']) ? 'selected' : ''; // Check against the student's group
                                                            ?>
                                                                    <option <?= $selected ?> value="<?= $group['group_id']; ?>"><?= $group['group_name']; ?></option>
                                                            <?php
                                                                endif;
                                                            endforeach;
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Select a group.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->


                                            </div> <!-- /row -->

                                            <div class="row">

                                                <!-- Group Category Dropdown -->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Group Category:</label>
                                                        <select id="group-category" class="form-control select2" required name="student_group_category">
                                                            <option selected disabled>-- Choose --</option>
                                                            <!-- Categories will be populated via AJAX -->
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Group category will be shown here.
                                                        </div>
                                                    </div>
                                                </div><!-- col -->

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Remarks: <small>(Optional)</small></label>
                                                        <input type="text" placeholder="Enter here..." class="form-control" name="student_remarks" value="<?= $student['student_remarks']; ?>">
                                                        <div class="invalid-feedback">
                                                            Enter remarks.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                            </div> <!-- /row -->

                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary" name='edit-student-btn'><i class='fa fas fa-save'></i> Update</button>
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

<!-- Fetch group category when group is selected and on page load -->
<script>
    $(document).ready(function() {
        // Function to fetch and populate group categories
        function fetchGroupCategories(groupName, selectedCategory) {
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
                        var selected = category.group_category_id == selectedCategory ? 'selected' : '';
                        $('#group-category').append('<option value="' + category.group_category_id + '" ' + selected + '>' + category.group_category + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching group categories:', error);
                }
            });
        }

        // On page load, fetch categories for the selected group
        var initialGroupId = '<?= $student['student_group']; ?>'; // Get the student's current group ID
        var initialGroupName = $('#group-select option:selected').text(); // Get the initially selected group name
        var selectedCategory = "<?= $student['student_group_category']; ?>"; // Get the student's current group category

        if (initialGroupName) {
            fetchGroupCategories(initialGroupName, selectedCategory); // Fetch categories with pre-selected category
        }

        // Fetch categories when the group is changed
        $('#group-select').change(function() {
            var groupName = $('#group-select option:selected').text(); // Get the selected group name
            fetchGroupCategories(groupName, null); // Fetch without pre-selecting a category
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