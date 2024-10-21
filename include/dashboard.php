<?php
// Fetch total active students
$total_active_students_qry = "SELECT COUNT(*) AS total_active_students FROM students WHERE student_status = 1";
$total_active_students_result = mysqli_query($cn, $total_active_students_qry);
$total_active_students = mysqli_fetch_assoc($total_active_students_result)['total_active_students'];

// Fetch total active teachers
$total_active_teachers_qry = "SELECT COUNT(*) AS total_active_teachers FROM teachers WHERE teacher_status = 1";
$total_active_teachers_result = mysqli_query($cn, $total_active_teachers_qry);
$total_active_teachers = mysqli_fetch_assoc($total_active_teachers_result)['total_active_teachers'];

// Fetch total active assessments
$total_active_assessments_qry = "SELECT COUNT(*) AS total_active_assessments FROM assessments WHERE assessment_status = 1";
$total_active_assessments_result = mysqli_query($cn, $total_active_assessments_qry);
$total_active_assessments = mysqli_fetch_assoc($total_active_assessments_result)['total_active_assessments'];

// Fetch total pending assessments
$total_pending_assessments_qry = "SELECT COUNT(*) AS total_pending_assessments FROM assessments WHERE assessment_status = 'pending'";
$total_pending_assessments_result = mysqli_query($cn, $total_pending_assessments_qry);
$total_pending_assessments = mysqli_fetch_assoc($total_pending_assessments_result)['total_pending_assessments'];
?>

<div class="main-content">
  <section class="section">
    <div class="row ">
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row ">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                  <div class="card-content">
                    <h5 class="font-15">Students</h5>
                    <h2 class="mb-3 font-18"><?php echo $total_active_students; ?></h2>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                  <div class="banner-img">
                    <img src="assets/img/banner/1.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row ">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                  <div class="card-content">
                    <h5 class="font-15"> Teachers</h5>
                    <h2 class="mb-3 font-18"><?php echo $total_active_teachers; ?></h2>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                  <div class="banner-img">
                    <img src="assets/img/banner/2.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row ">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                  <div class="card-content">
                    <h5 class="font-15">Active Assessments</h5>
                    <h2 class="mb-3 font-18"><?php echo $total_active_assessments; ?></h2>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                  <div class="banner-img">
                    <img src="assets/img/banner/3.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
          <div class="card-statistic-4">
            <div class="align-items-center justify-content-between">
              <div class="row ">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                  <div class="card-content">
                    <h5 class="font-15">Pending Assessments</h5>
                    <h2 class="mb-3 font-18"><?php echo $total_pending_assessments; ?></h2>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                  <div class="banner-img">
                    <img src="assets/img/banner/4.png" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>