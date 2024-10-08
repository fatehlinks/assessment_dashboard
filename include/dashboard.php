<?php
  include('config.php');
  $get_active_courses="SELECT COUNT(course_id) AS total_active_courses FROM courses"; 
  $get_active_courses_run=mysqli_query($cn,$get_active_courses);
  if($row_for_active=mysqli_fetch_assoc($get_active_courses_run)){
    $total_active_courses=$row_for_active['total_active_courses']; 
  }

  //New Enrolled
  $get_new_enrolled="SELECT COUNT(enrolled_id) AS total_new_enrolled FROM enrolled WHERE enrolled_status=1"; 
  $get_new_enrolled_run=mysqli_query($cn,$get_new_enrolled);
  if($row_for_new_enrolled=mysqli_fetch_assoc($get_new_enrolled_run)){
    $total_new_enrolled=$row_for_new_enrolled['total_new_enrolled']; 
  }

  //Dropped
  $get_dropped_enrolled="SELECT COUNT(enrolled_id) AS total_dropped_enrolled FROM enrolled WHERE enrolled_status=0"; 
  $get_dropped_enrolled_run=mysqli_query($cn,$get_dropped_enrolled);
  if($row_for_dropped_enrolled=mysqli_fetch_assoc($get_dropped_enrolled_run)){
    $total_dropped_enrolled=$row_for_dropped_enrolled['total_dropped_enrolled']; 
  }

   //Passout
   $get_passout_enrolled="SELECT COUNT(enrolled_id) AS total_passout_enrolled FROM enrolled WHERE enrolled_status=2"; 
   $get_passout_enrolled_run=mysqli_query($cn,$get_passout_enrolled);
   if($row_for_passout_enrolled=mysqli_fetch_assoc($get_passout_enrolled_run)){
     $total_passout_enrolled=$row_for_passout_enrolled['total_passout_enrolled']; 
   }

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
                          <h5 class="font-15">Active Courses</h5>
                          <h2 class="mb-3 font-18"><?= $total_active_courses; ?></h2>
                          <p class="mb-0"><span class="col-green">- - - - -</span></p>
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
                          <h5 class="font-15"> New Enrolled</h5>
                          <h2 class="mb-3 font-18"><?= $total_new_enrolled; ?></h2>
                          <p class="mb-0"><span class="col-orange">- - - - -</span></p>
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
                          <h5 class="font-15">Dropped</h5>
                          <h2 class="mb-3 font-18"><?= $total_dropped_enrolled; ?></h2>
                          <p class="mb-0"><span class="col-green">- - - - -</span></p>
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
                          <h5 class="font-15">Passout</h5>
                          <h2 class="mb-3 font-18"><?= $total_passout_enrolled; ?></h2>
                          <p class="mb-0"><span class="col-green">- - - - -</span></p>
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