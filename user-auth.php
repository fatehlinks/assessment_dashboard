<?php include('auth.php'); ?>

<?php
if ($admin_row['admin_role'] != 0) {
    echo "<script>window.open('logout.php','_SELF')</script>";
}
?>