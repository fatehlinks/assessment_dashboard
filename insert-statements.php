<?php include('auth.php'); ?>
<?php
// Add admin profile section
if (isset($_POST['add-admin-profile-btn'])) {
    $admin_name = mysqli_real_escape_string($cn, $_POST['admin_name']);
    $admin_email = mysqli_real_escape_string($cn, $_POST['admin_email']);
    $admin_passwrod = mysqli_real_escape_string($cn, $_POST['admin_passwrod']);
    $admin_role = $_POST['admin_role'];
    $admin_username = mysqli_real_escape_string($cn, $_POST['admin_username']);
    $admin_recovery_email = mysqli_real_escape_string($cn, $_POST['admin_recovery_email']);
    $admin_status = 1;

    // Check if the email already exists
    $check_email_qry = "SELECT * FROM admin WHERE admin_email = '$admin_email'";
    $check_email_qry_run = mysqli_query($cn, $check_email_qry);

    if (mysqli_num_rows($check_email_qry_run) > 0) {
        // Email already exists
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = "The email address is already in use. Please choose a different one.";
        header("location:admin-profile.php");
        exit();
    } else {
        // Proceed with inserting new admin profile
        $admin_profile_qry = "INSERT INTO admin (admin_name, admin_email, admin_password, admin_role, admin_username, admin_recovery_email, admin_status) 
                              VALUES('$admin_name', '$admin_email', '$admin_password', '$admin_role', '$admin_username', '$admin_recovery_email', '$admin_status')";
        $admin_profile_qry_run = mysqli_query($cn, $admin_profile_qry);

        if ($admin_profile_qry_run) {
            $_SESSION['success_sweetalert_displayed'] = true;
            header("location:admin-profile.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($cn);
        }
    }
}
// End of add admin profile section


// Add course section 
if (isset($_POST['add-course-btn'])) {
    $course_name = mysqli_real_escape_string($cn, $_POST['course_name']);
    $course_description = mysqli_real_escape_string($cn, $_POST['course_description']);
    $real_time = time();
    // File upload code
    $file_name = $_FILES['course_picture']['name'];
    $insert_picture = "uploads/courses/$real_time" . $file_name; // variable for insert into database
    $target_dir = "uploads/courses/$real_time";
    $target_file = $target_dir . basename($_FILES["course_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["course_picture"]["size"] > 102400) {
        $uploadOk = 0;
        $_SESSION['error_sweetalert_displayed'] = true;
        header("location:courses.php");
        exit();
    }
    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $uploadOk = 0;
        $_SESSION['error_sweetalert_displayed'] = true;
        header("location:courses.php");
        exit();
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["course_picture"]["tmp_name"], $target_file)) {
            $add_course_qry = "INSERT INTO courses (course_name,course_description,course_picture) VALUES ('$course_name','$course_description','$insert_picture')";
            $add_course_qry_run = mysqli_query($cn, $add_course_qry);
            if ($add_course_qry_run) {
                $_SESSION['success_sweetalert_displayed'] = true;
                header("location:courses.php");
                exit();
            }
        }
    }
}

// End of add course section




?>