<?php include('user-auth.php'); ?>
<?php
if (isset($_POST['add-category'])) {
    $category_name = mysqli_real_escape_string($cn, $_POST['category_name']);
    $category_group =  $_POST['category_group']; // This is the group id

    // First, check if a category with the same name and group already exists
    $check_duplicate_qry = "SELECT * FROM category WHERE category_name = '$category_name' AND group_id = '$category_group'";
    $check_duplicate_run = mysqli_query($cn, $check_duplicate_qry);

    if (mysqli_num_rows($check_duplicate_run) > 0) {
        // If a category with the same name in the group already exists, show error
        $_SESSION['error_sweetalert_displayed'] = true;
        $_SESSION['error_message'] = 'This Category name already exists in this group.';
        header("Location: add-category.php");
        exit();
    } else {
        // If no duplicate found, proceed with the insertion
        $category_status = 1; // Default status is active

        $insert_category_qry = "INSERT INTO category (category_name, group_id, category_status) 
                               VALUES ('$category_name', '$category_group', '$category_status')";
        $insert_category_qry_run = mysqli_query($cn, $insert_category_qry);

        if ($insert_category_qry_run) {
            $_SESSION['primary_sweetalert_displayed'] = true;
            header("Location: add-category.php");
            exit();
        } else {
            $_SESSION['error_sweetalert_displayed'] = true;
            $_SESSION['error_message'] = 'Error adding Category. Please try again.';
            header("Location: add-category.php");
        }
    }
}
