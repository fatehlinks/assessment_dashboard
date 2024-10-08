<?php include('auth.php'); ?>
<?php
    $get_id=$_GET['id'];
    $delete_admin_qry="DELETE FROM admin WHERE admin_id='$get_id'";
    $delete_admin_qry_run=mysqli_query($cn,$delete_admin_qry);
    $_SESSION['success_sweetalert_displayed']=true;
    header("location:view-admin.php");
    exit();
?>