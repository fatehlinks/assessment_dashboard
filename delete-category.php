<?php include('user-auth.php'); ?>

<?php
if (isset($_GET['id'])) {

    $category_id = mysqli_real_escape_string($cn, $_GET['id']);

    $delete_category_qry = "DELETE FROM category WHERE category_id = '$category_id'";

    // Run the queryh
    if (mysqli_query($cn, $delete_category_qry)) {
        $_SESSION['primary_sweetalert_displayed'] = true;
        header("location:add-category.php");
        exit();
    } else {
        // Handle error
        echo "Error: " . mysqli_error($cn);
    }
} else {
    header("location:add-category.php");
    exit();
}
?>
