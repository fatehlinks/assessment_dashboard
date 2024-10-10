<?php include('auth.php'); ?>
<!DOCTYPE html>
<html lang="en">
<!-- invoice.html  21 Nov 2019 04:05:05 GMT -->

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Student Profile</title>
  <?php include_once('include/html-sources.html'); ?>

  <?php
  // Fetch student data based on ID from the URL
  if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch student data
    $query = "SELECT students.*, groups.group_name , groups.group_category
              FROM students 
              JOIN groups ON students.student_group = groups.group_id
               WHERE student_id = ? AND  student_status != -1";
    $stmt = $cn->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $student = $result->fetch_assoc();
      $student_name = $student['student_name'];
      $student_father_name = $student['student_father_name'];
      $student_mobile = $student['student_mobile'];
      $student_cnic = $student['student_cnic'];
      $student_address = $student['student_address'];
      $student_dob = date("d-M-Y", strtotime($student['student_dob']));

      $student_group = $student['group_name'];
      $student_group_category = $student['group_category'];
      $student_section = $student['student_section'];
      // Add other student data as needed
    } else {
      // Handle case where student is not found
      $student_name = "Not Found";
      $student_address = "";
    }

    $stmt->close();
    $cn->close();
  } else {
    // Handle case where no ID is provided
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
            <div class="invoice">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <h2> <img src="./assets/img/tef-logo.png" alt="tef logo">
                      </h2>
                      <div class="invoice-number">Reg # : <?= $student['student_reg_id']; ?></div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <h5 class="mb-2">Studnet Details :</h5>
                          <div class="d-flex flex-column">
                            <p class="m-0"> <strong>Name :</strong> <?php echo $student_name; ?></p>
                            <p class="m-0"><strong>Category :</strong> <?php echo $student_father_name; ?></p>
                            <p class="m-0"> <strong>CNIC :</strong> <?php echo $student_cnic; ?></p>
                            <p class="m-0"> <strong>DOB :</strong> <?php echo $student_dob; ?></p>
                          </div>
                          <!-- Add more student fields as necessary -->
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <h5 class="mb-2">Contact Details :</h5>
                          <div class="d-flex flex-column">
                            <p class="m-0"> <strong>Mobile :</strong> <?php echo $student_mobile; ?></p>
                            <p class="m-0"> <strong>Address :</strong> <?php echo $student_address; ?></p>

                          </div>
                          <!-- Add shipping address or additional details if applicable -->
                        </address>
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-md-6">
                        <address>
                          <h5 class="mb-2">Program :</h5>
                          <div class="d-flex flex-column gap-0">
                            <p class="m-0"> <strong>Group :</strong> <?php echo $student_group; ?></p>
                            <p class="m-0"><strong>Category :</strong> <?php echo $student_group_category; ?></p>
                            <p class="m-0"> <strong>Section :</strong> <?php echo $student_section; ?></p>
                          </div>
                          <!-- Add more student fields as necessary -->
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <!-- <strong>Order Date:</strong><br>
                          June 26, 2018<br><br> -->
                        </address>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="section-title">Assessment Summary</div>
                    <p class="section-lead"></p>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md mt-3">
                        <tr>
                          <th data-width="40">#</th>
                          <th>Item</th>
                          <th class="text-center">Price</th>
                          <th class="text-center">Quantity</th>
                          <th class="text-right">Totals</th>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>Mouse Wireless</td>
                          <td class="text-center">$10.99</td>
                          <td class="text-center">1</td>
                          <td class="text-right">$10.99</td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>Keyboard Wireless</td>
                          <td class="text-center">$20.00</td>
                          <td class="text-center">3</td>
                          <td class="text-right">$60.00</td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>Headphone Blitz TDR-3000</td>
                          <td class="text-center">$600.00</td>
                          <td class="text-center">1</td>
                          <td class="text-right">$600.00</td>
                        </tr>
                      </table>
                    </div>

                  </div>
                </div>
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
    // Function to print the invoice
    document.getElementById('print-button').onclick = function() {
      window.print();
    };
  </script>
</body>

</html>