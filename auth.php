<?php
    session_start();   
    ob_start();   
	
	  if(!isset($_SESSION['admUser']))
	  {
		echo "<script>window.open('index.php','_SELF')</script>";  
		  
	  }
	include('config.php'); 
	$adminAuthViaEmail=$_SESSION['admUser'];
	$admin_info_qry="SELECT * FROM admin WHERE admin_email='$adminAuthViaEmail'";
	$admin_info_qry_run = mysqli_query($cn,$admin_info_qry) or die(mysqli_error());;
	if($admin_row=mysqli_fetch_array($admin_info_qry_run))
		{
			$admin_id=$admin_row['admin_id'];
			$admin_name=$admin_row['admin_name'];
			$admin_email=$admin_row['admin_email'];
			$admin_role=$admin_row['admin_role'];
			$admin_role=$admin_row['admin_username'];
			$admin_recovery_email=$admin_row['admin_recovery_email'];
			
		}    

	?>