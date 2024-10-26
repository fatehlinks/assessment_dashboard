<?php include('auth.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Student Profile</title>
  <?php include_once('include/html-sources.html'); ?>

  <?php
  if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch student data
    $query = "SELECT students.*, g1.group_name, c1.category_name
              FROM students 
              JOIN groups AS g1 ON students.student_group = g1.group_id
              JOIN category AS c1 ON students.student_group_category = c1.category_id
              WHERE students.student_id = $student_id AND students.student_status != -1";
    $result = mysqli_query($cn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $student = mysqli_fetch_assoc($result);
      $student_name = $student['student_name'];
      $student_father_name = $student['student_father_name'];
      $student_mobile = $student['student_mobile'];
      $student_cnic = $student['student_cnic'];
      $student_address = $student['student_address'];
      $student_dob = date("d-M-Y", strtotime($student['student_dob']));
      $student_group = $student['group_name'];
      $student_group_category = $student['category_name'];
      $student_section = $student['student_section'];
      $student_grade = $student['student_grade'];
    } else {
      $student_name = "Not Found";
      $student_address = "";
    }
  } else {
    $student_name = "No Student Selected";
    $student_address = "";
  }
  ?>
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
            <div class="invoice" id="invoice">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="row align-items-center px-2">
                      <div class="col-sm-6">
                        <h4><img src="./assets/img/tef-logo.png" alt="tef logo"></h4>
                      </div>
                      <div class="col-sm-6">
                        <h4 class="text-right">Reg # : <?= $student['student_reg_id']; ?></h4>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-6 ">
                        <div>
                          <h5 class="mb-2">Student Details :</h5>
                          <p><strong>Name :</strong> <?php echo $student_name; ?></p>
                          <p><strong>Father's Name :</strong> <?php echo $student_father_name; ?></p>
                          <p><strong>CNIC :</strong> <?php echo $student_cnic; ?></p>
                          <p><strong>DOB :</strong> <?php echo $student_dob; ?></p>
                        </div>
                      </div>

                      <div class="col-sm-6 text-right">
                        <div>
                          <h5 class="mb-2">Contact Details :</h5>
                          <p><strong>Mobile :</strong> <?php echo $student_mobile; ?></p>
                          <p><strong>Address :</strong> <?php echo $student_address; ?></p>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-sm-6">
                        <div>
                          <h5 class="mb-2">Program :</h5>
                          <p><strong>Group :</strong> <?php echo $student_group; ?></p>
                          <p><strong>Category :</strong> <?php echo $student_group_category; ?></p>
                          <p><strong>Section :</strong> <?php echo $student_section; ?></p>
                          <p><strong>Grade :</strong> <?php echo $student_grade; ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <?php
                // Fetch assessments for this student
                // Fetch assessments for this student using FIND_IN_SET to check student_id within marking_student_id string
                $query = "SELECT m.marking_obtained_marks, m.marking_total_marks, a.assessment_id, m.marking_student_id
          FROM marking m
          JOIN assessments a ON m.marking_assessment_id = a.assessment_id
          WHERE FIND_IN_SET('$student_id', m.marking_student_id) > 0 AND m.marking_status = 1";


                $result = mysqli_query($cn, $query);

                // echo mysqli_num_rows($result);
                // exit;
                if ($result && mysqli_num_rows($result) > 0) {
                  echo "
                      <div class='row mt-4'>
                        <div class='col-12'>
                        <div class='card shadow-none'>
                          <div class='card-header'>
                            <h4 class='m-0 mb-2'>Assessment Summary</h4>
                          </div>
                          <div class='table-responsive'>
                            <table class='table table-striped table-hover table-bordered text-center' style='width:100%;'>
                              
                                <tr class='table-dark'>
                                  <th>Assessment No.</th>
                                  <th>Obtained Marks</th>
                                  <th>Total Marks</th>
                                  <th>Percentage</th>
                                </tr>
                           
                              <tbody>";

                  while ($row = mysqli_fetch_assoc($result)) {
                    // Get marks as arrays
                    $obtainedMarksArray = explode(',', $row['marking_obtained_marks']);
                    $studentIdsArray = explode(',', $row['marking_student_id']);
                    $assessmentId = $row['assessment_id'];

                    // Find the specific entry for the current student
                    $studentIndex = array_search($student_id, $studentIdsArray);

                    if ($studentIndex !== false && isset($obtainedMarksArray[$studentIndex])) {
                      $obtainedMark = $obtainedMarksArray[$studentIndex];
                      $totalMark = $row['marking_total_marks'];
                      $percentage = ($totalMark > 0) ? ($obtainedMark / $totalMark) * 100 : 0;

                      echo "<tr>
                              <td>{$assessmentId}</td>
                              <td>{$obtainedMark}</td>
                              <td>{$totalMark}</td>
                              <td>{$percentage}%</td>
                            </tr>";
                    } else {
                      echo "<tr><td colspan='4'>Error: Data mismatch for student ID {$student_id} in assessment {$assessmentId}.</td></tr>";
                    }
                  }
                  echo "
                              </tbody>
                            </table>
                          </div>
                        </div>
                        </div>
                      </div>";
                }
                ?>
              </div>
              <hr>
              <div class="text-md-right">
                <button class="btn btn-warning btn-icon icon-left" id="print-button"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </section>
      </div>
      <?php include_once('include/footer.php'); ?>
    </div>
  </div>

  <?php include_once('include/js-sources.html'); ?>

  <script>
    document.getElementById('print-button').onclick = function() {
      var invoiceContent = document.getElementById('invoice').innerHTML;
      var originalContent = document.body.innerHTML;

      document.body.innerHTML = invoiceContent;
      window.print();
      document.body.innerHTML = originalContent;
    };
  </script>
</body>

</html>