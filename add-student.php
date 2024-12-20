<?php include('auth.php'); ?>
<?php
//Set a session variable to trigger the SweetAlert
if (!empty($_SESSION['primary_sweetalert_displayed'])) {
    $displayprimarySweetAlert = true;
    unset($_SESSION['primary_sweetalert_displayed']);
}

// Fetch groups from the database
$select_groups = "SELECT * FROM groups WHERE group_status = 1"; // Only fetch active groups
$select_groups_run = mysqli_query($cn, $select_groups);


// Fetch schools from the database
$select_schools = "SELECT * FROM schools  JOIN admin ON schools.school_id = admin.admin_role WHERE school_status = 1"; // Only fetch active groups
$select_schools_run = mysqli_query($cn, $select_schools);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Student</title>
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
                                    <form class="needs-validation" novalidate="" method="post" action="insert-student.php">
                                        <div class="card-header">
                                            <h4><i data-feather="plus"></i> Add Student</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Reg ID <span class="text-danger">*</span> :</label>
                                                        <input type="number" min='1' placeholder="Enter here..." class="form-control" required="" name="student_reg_id">
                                                        <div class="invalid-feedback">
                                                            Registration ID is Missing...!
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>CNIC<span class="text-danger">*</span> :</label>
                                                        <input type="text" data-inputmask="'mask':'99999-9999999-9'" placeholder="xxxxx-xxxxxxx-x" class="form-control" required="" name="student_cnic">
                                                        <div class="invalid-feedback">
                                                            What's your CNIC?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Mobile<span class="text-danger">*</span> : </label>
                                                        <input type="text" data-inputmask="'mask':'9999-9999999'" placeholder="xxxx-xxxxxxx" class="form-control" required="" name="student_mobile">
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
                                                        <input type="text" placeholder="Enter here..." onkeyup="this.value = this.value.toUpperCase();" class="form-control" required="" name="student_name">
                                                        <div class="invalid-feedback">
                                                            What's your Name?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Father Name<span class="text-danger">*</span> :</label>
                                                        <input type="text" placeholder="Enter here..." onkeyup="this.value = this.value.toUpperCase();" class="form-control" required="" name="student_father_name">
                                                        <div class="invalid-feedback">
                                                            What's your Father Name?
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Date of Birth<span class="text-danger">*</span> :</label>
                                                        <input type="date" class="form-control" required="" name="student_dob">
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
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <option>Male</option>
                                                            <option>Female</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Choose your Gender....!
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Address<span class="text-danger">*</span> :</label>
                                                        <input type="text" placeholder="Enter here..." class="form-control" required="" name="student_address">
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

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Section<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" required="" name="student_section">
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
                                                            Choose profile role
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Group<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" id='group-select' required="" name="student_group">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php
                                                            // Loop through groups and add them as options in the select
                                                            while ($group = mysqli_fetch_assoc($select_groups_run)) {
                                                                echo "<option value='" . $group['group_id'] . "'>" . $group['group_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Select a group.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->



                                            </div> <!-- /row -->

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Category:</label>
                                                        <select id="group-category" class="form-control select2" name="student_group_category" required>
                                                            <option selected disabled>-- Choose --</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Group category will be shown here.
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>School<span class="text-danger">*</span> :</label>
                                                        <select class="form-control select2" id='school-select' required="" name="student_school">
                                                            <option selected disabled value="">-- Choose --</option>
                                                            <?php
                                                            // Loop through groups and add them as options in the select
                                                            while ($school = mysqli_fetch_assoc($select_schools_run)) {
                                                                echo "<option value='" . $school['school_id'] . "'>" . $school['school_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Select a school.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->


                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Remarks: <small>(Optional)</small></label>
                                                        <input type="text" placeholder="Enter here..." class="form-control" name="student_remarks">
                                                        <div class="invalid-feedback">
                                                            Enter remarks.
                                                        </div>
                                                    </div>
                                                </div> <!-- /col -->
                                            </div> <!-- /row -->
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary" name='add-student-btn'><i class='fa fas fa-plus'></i> Save & Submit</button>
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
    });
</script>



<?php if (!empty($displayprimarySweetAlert)): ?>
    <script>
        $(document).ready(function() {
            swal({
                title: "Congrats",
                text: "Operation successfully completed.",
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