<?php include('auth.php'); ?>
<?php
$get_id = $_GET['id'];
$delete_admin_qry = "DELETE FROM admin WHERE admin_id='$get_id'";
$delete_admin_qry_run = mysqli_query($cn, $delete_admin_qry);
$_SESSION['primary_sweetalert_displayed'] = true;
header("location:admin-profile.php");
exit();
?>