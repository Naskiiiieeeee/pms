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
                $query = "SELECT * FROM `request` WHERE `transactionCode` = '$transaction_id' ";
                $result = mysqli_query($con, $query);
                while($data = mysqli_fetch_assoc($result)){
                    $status = $data['statusTwo'];
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

            <form action="action.php" method="post">
                <input type="hidden" class="form-control" name="transcode" value="<?= $data['transactionCode'];?>">
                <input type="hidden" class="form-control" name="dateNeeded" value="<?= $data['dateNeeded'];?>">
                <input type="hidden" class="form-control" name="empID" value="<?= $data['empID'];?>">
                <input type="hidden" class="form-control" name="Reason" value="<?= $data['Reason'];?>">
                <input type="hidden" class="form-control" name="addSupply" value="<?= $data['addSupply'];?>">
                <input type="hidden" class="form-control" name="quantity" value="<?= $data['quantity'];?>">
                <input type="hidden" class="form-control" name="totalAmount" value="<?= number_format($total_cost, 2); ?>">

                <input type="text" name="supplier" id="" class="form-control my-2" placeholder="Enter Supplier's Name" required>

                <button type="submit" name="btnPostOrder" class="btn btn-primary" onclick="return confirm('Post this Order?');"> <i class="bi bi-check2-circle"></i> APPROVED</button>
                <button type="submit" name="btnUnpostOrder" class="btn btn-danger" onclick="return confirm('Decline this Order?');"><i class="bi bi-x-circle"></i> DECLINE</button>
            </form>

            <?php } ?>
            <hr>
      </div>
    </div>
  </div>

</div>



<?php include_once("./components/footscript.php"); ?>