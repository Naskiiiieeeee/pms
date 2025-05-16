<?php 
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['fullname']) || !isset($_SESSION['role'])) {
    '<script>alert("Unauthorized access!"); window.location = "index.php";</script>';
    exit;
}
$notification = $_SESSION['notification'] ?? '';
$notificationType = $_SESSION['notification_type'] ?? 'success'; 
unset($_SESSION['notification'], $_SESSION['notification_type']);

$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];
$role = $_SESSION['role'];

include_once("./components/header.php");
include_once("./components/sidebar.php");
include_once("./components/innernavbar.php");
include_once(__DIR__ . "/../connection/config.php");
$con = connection();

?>
<!-- Page Content  -->
<div class="row">
  <div class="col-lg-8 md-3">
    <div class="card">
      <div class="card-body">
            <center>
                <img src="./images/bsu.jpg" alt="Profile" height="100px" width="100px" class="rounded-circle">
                <h2>Request Approval Status</h2>
            </center>
            <hr>
            <hr>
            <?php 
                $transaction_id = $_GET['ID'];
                $query = "SELECT * FROM `request` WHERE `transactionCode` = '$transaction_id' AND `empID` = '$username'";
                $result = mysqli_query($con, $query);
                while($data = mysqli_fetch_assoc($result)){
                    $status = $data['statusOne'];
            ?>
            <div class="receipt-info">
                <p>Date Needed: <b><?= $data['dateNeeded'];?></b> </p>
                <p>Transaction ID: <b><?= $data['transactionCode'];?></b> </p>
                <p>Request by: <b><?= $data['empID'];?></b> </p>
                <p>Reason for Request: <b><?= $data['Reason'];?></b></p>
                <?php
                    $statusLabel = match((int)($status ?? 0)) {
                            0 => "Pending",
                            1 => "Approved",
                            2 => "Declined",
                            default => "Unknown"
                        };
                    ?>
                <p>Status: <b><?= $statusLabel ?></b> </p>
            </div>
            <div class="receipt-items">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Items</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php 
                                        $imploded_data = $data['addSupply'];
                                        $exploded_items = explode(",", $imploded_data);

                                        foreach ($exploded_items as $value) {
                                            echo "• ".$value . "<br>";
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        $imploded_data = $data['quantity'];
                                        $exploded_quantity = explode(",", $imploded_data);
                                        
                                        foreach ($exploded_quantity as $value) {
                                            echo "• ".$value."<br>";
                                        }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <p><?php echo $data['notes'] ?? '';?></p>
            </div>
            <?php } ?>
            <hr>
      </div>
    </div>
  </div>

</div>



<?php include_once("./components/footscript.php"); ?>