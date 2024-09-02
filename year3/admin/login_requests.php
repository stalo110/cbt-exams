<?php include "includes/header.php" ?>
<?php
$sub = "Student List";
$sql= "SELECT * FROM class";
$resultsQuery = mysqli_query($connection, $sql);
?>
<?php include "includes/navbar.php" ?>
<?php include "includes/sidebar.php" ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
              <div class="card">
                  <div class="card-body">

                   <!-- Display Success Message -->
                   <?php
                    if (isset($_SESSION['message'])) {
                        echo "<div class='alert alert-success' role='alert'>";
                        echo $_SESSION['message'];
                        echo "</div>";

                        // Unset the message after displaying it
                        unset($_SESSION['message']);
                    }
                    ?>
                    
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <div>
                          <form method="POST" action="process_approval.php">
                            <button type="submit" name="approve_all" class='btn btn-primary btn-xs'>Approve All</button>
                          </form>
                        </div>
                        <br>
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Reg No.</th>
                            <th>Request Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $st_query = "SELECT * FROM login_requests";
                          $select_students_query = mysqli_query($connection, $st_query);

                          if (!$select_students_query) {
                              die("QUERY FAILED: " . mysqli_error($connection));
                          }

                          while ($st_row = mysqli_fetch_assoc($select_students_query)) {
                              $st_id = $st_row['id'];
                              $st_reg_no = $st_row['reg_no'];
                              $st_request_time = $st_row['request_time'];
                              $st_status = $st_row['status'];

                              echo "<tr>";
                              echo "<td>{$st_id}</td>";
                              echo "<td>{$st_reg_no}</td>";
                              echo "<td>{$st_request_time}</td>";
                              echo "<td>{$st_status}</td>";
                              echo "<td>";
                              echo "<form method='POST' action='process_approval.php'>";
                              echo "<input type='hidden' name='request_id' value='{$st_id}'>";
                              echo "<button type='submit' name='approve' class='btn btn-primary btn-xs'>Approve</button>";
                              echo "<button type='submit' name='reject' class='btn btn-danger btn-xs'>Reject</button>";
                              echo "</form>";
                              echo "</td>";
                              echo "</tr>";
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
</section>
<?php include "includes/footer.php" ?>
