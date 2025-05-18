<?php 
ob_start();

include_once(__DIR__ . "/../connection/config.php");
$con = connection();

if (isset($_POST['from']) && isset($_POST['to']) && isset($_POST['export_excel']) && $_POST['export_excel'] == "1") {
    $from = $_POST['from'];
    $to = $_POST['to'];

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=request_report_" . date('YmdHis') . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo "<table border='1'>";
    echo "<tr>
            <th>Tbl ID</th>
            <th>Request ID</th>
            <th>Product Names</th>
            <th>Product Quantities</th>
            <th>Department</th>
            <th>Branch</th>
            <th>Requested By</th>
            <th>Date Needed</th>
          </tr>";

    $i = 1;
    $filterBetweenDates = "SELECT * FROM `request` WHERE `dateNeeded` BETWEEN '$from' AND '$to'";
    $result = mysqli_query($con, $filterBetweenDates);
    while ($rows = mysqli_fetch_assoc($result)) {
        $supID = $rows["empID"];

        echo "<tr>";
        echo "<td>" . $i++ . "</td>";
        echo "<td>" . $rows['transactionCode'] . "</td>";

        $names = explode(",", $rows['addSupply']);
        echo "<td>" . implode("<br>", array_map(fn($v) => "• $v", $names)) . "</td>";

        $quantities = explode(",", $rows['quantity']);
        echo "<td>" . implode("<br>", array_map(fn($v) => "• $v", $quantities)) . "</td>";

        $selectSup = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$supID'");
        $fullname = "";
        while ($rowSup = mysqli_fetch_assoc($selectSup)) {
            $department = $rowSup['department'];
            $campus = $rowSup['campus'];
            $fullname = $rowSup['fullname'];
        }

        echo "<td>" . $department . "</td>";
        echo "<td>" . $campus . "</td>";
        echo "<td>" . $fullname . "</td>";
        echo "<td>" . $rows['dateNeeded'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
    exit();
}

include_once("./components/header.php");
include_once("./components/sidebar.php");
include_once("./components/innernavbar.php");
?>
<!-- Page Content  -->
<h2 class="mb-4">PMS Request Report</h2>

<div class="row">
  
  <div class="col-lg-12 md-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title noprint">Recent Records</h5>
        <div class="table-responsive">
            <form id="filterForm" action="" method="post" class="noprint d-flex align-items-center gap-2 mb-2">
                <div class="row col-lg-12 md-3">
                    <div class="form-group col-lg-6">
                        <label class="text-dark fw-bold fs-6">From</label>
                        <input type="date" name="from" class="form-control" required>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="text-dark fw-bold fs-6">To</label>
                        <input type="date" name="to"  class="form-control" required>
                    </div>
                    <div class="form-group col-lg-3 my-1">
                        <input type="hidden" name="export_excel" id="export_excel" value="0">
                        <button type="submit" id="filterBtn" class="btn btn-success"><i class="fa fa-filter"></i> Filter</button>
                    </div>
                </div>
            </form>

            <hr>

            <table class="table" id="dataTable">
              <thead>
                <tr>
                  <th scope="col">Tbl ID</th>
                  <th scope="col">Request ID</th>
                  <th scope="col">Product Names</th>
                  <th scope="col">Product Quantities</th>
                  <th scope="col">Department/Branch</th>
                  <th scope="col">Requested By</th>
                  <th scope="col">Date Needed</th>
                </tr>
              </thead>
              <tbody id="tableBody">
              <?php
                $i = 1;
                if (isset($_POST['from']) && isset($_POST['to'])) {
                    $from = $_POST['from'];
                    $to = $_POST['to'];
                    $filterBetweenDates = "SELECT * FROM `request` WHERE `dateNeeded` BETWEEN '$from' AND '$to'";
                    $result = mysqli_query($con, $filterBetweenDates);
                    while ($rows = mysqli_fetch_assoc($result)) {
                        $supID = $rows["empID"];
              ?>
                <tr class="tableRow">
                  <td><?= $i++; ?></td>
                  <td><?= $rows['transactionCode'] ?></td>
                  <td>
                    <?php
                      foreach (explode(",", $rows['addSupply']) as $value) {
                          echo "• $value<br>";
                      }
                    ?>
                  </td>
                  <td>
                    <?php
                      foreach (explode(",", $rows['quantity']) as $value) {
                          echo "• $value<br>";
                      }
                    ?>
                  </td>
                  <?php 
                    $selectSup = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$supID'");
                    while ($rowSup = mysqli_fetch_assoc($selectSup)) {
                  ?>
                  <td class=""><?=  $rowSup['department'];?> ( <?=  $rowSup['campus'];?> ) </td>
                  <td><?= $rowSup['fullname'] ?></td>
                  <?php } ?>
                  <td><?= $rows['dateNeeded'] ?></td>
                </tr>
              <?php
                    }
                }
                ob_end_flush();
              ?>
              </tbody>
            </table>
            <a href="adminPrintRequest" class="btn btn-danger noprint mb-2"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Filter Data',
            text: 'Do you also want to save the filtered results as Excel?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, export to Excel',
            cancelButtonText: 'No, just filter and print',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('export_excel').value = "1";
            } else {
                document.getElementById('export_excel').value = "0";
            }
            e.target.submit();
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_POST['from']) && isset($_POST['to']) && (!isset($_POST['export_excel']) || $_POST['export_excel'] != "1")): ?>
            window.print();
            document.getElementById('sidebar').style.display = 'none';
            setTimeout(function () {
                window.close();
            }, 100);
        <?php endif; ?>
    });
</script>

<?php include_once("./components/footscript.php"); ?>