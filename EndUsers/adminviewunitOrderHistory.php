<?php 
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
                <h2>Order Form</h2>
            </center>
            <hr>
            <hr>
            <?php 
                $transaction_id = $_GET['ID'];
                $query = "SELECT * FROM `orders` WHERE `orderID` = '$transaction_id'";
                $result = mysqli_query($con, $query);
                while($data = mysqli_fetch_assoc($result)){
                    $total_cost = 0;
                    $userID = $data['empID'];
                    $status = $data['status'];   
            ?>
            <div class="receipt-info">
                <p>Date Needed: <b><?= $data['dateNeeded'];?></b> </p>
                <p>Confirmation Date: <b><?= $data['datePosted'];?></b> </p>
                <p>Request ID: <b><?= $data['requestID'];?></b> </p>
                <p>Transaction ID: <b><?= $data['orderID'];?></b></p>
                <p>Request by: <b><?= $data['empID'];?></b></p>
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
                    <p>Remarks:
                        <?php
                            if ($data['status'] == 0 ) {
                                echo '
                                    <span class="badge bg-warning text-white p-2">
                                        <i class="fa fa-exclamation-triangle"></i> PENDING 
                                    </span>
                                ';
                            } elseif ($data['status'] == 2 ) {
                                echo '
                                    <span class="badge bg-danger text-white p-2">
                                        <i class="fa fa-exclamation-triangle"></i> DECLINED 
                                    </span>
                                ';
                            } else {
                                // Closing PHP to handle dynamic content and then reopening
                        ?>
                                <a href="adminsendConfirmation.php?ID=<?php echo $data["orderID"]; ?>" class="text-white">
                                    <span class="badge bg-success p-2">
                                        <i class="fa fa-check-circle"></i> Approved!, Please Click me to send a message 
                                    </span>
                                </a>
                        <?php
                            }
                        ?>
                    </p>
                </div>

            <?php } ?>
            <hr>
      </div>
    </div>
  </div>

</div>



<?php include_once("./components/footscript.php"); ?>