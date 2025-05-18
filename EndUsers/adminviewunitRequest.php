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
                <h2>Request Approval Status</h2>
            </center>
            <hr>
            <hr>
            <?php 
                $transaction_id = $_GET['ID'];
                $query = "SELECT * FROM `request` WHERE `transactionCode` = '$transaction_id' ";
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

            <form action="action.php" method="post">
                <input type="hidden" class="form-control" name="transcode" value="<?= $data['transactionCode'];?>">
                <button type="submit" name="btnApprovedRequest" class="btn btn-primary" onclick="return confirm('Approved this Request?');"> APPROVED</button>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ttt">
                    DECLINE
                </button>
            </form>
            <!-- Modal -->
            <div class="modal fade" id="ttt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="action.php" method="post">
                            <input type="hidden" class="form-control" name="transcode" value="<?= $data['transactionCode'];?>">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Decline Request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <textarea name="notes" id="" rows="5" class="form-control">We apologize, but we cannot approve your request now. If you wish to provide additional information or clarification, please request it again. Thank you.</textarea>
                                    </div>
                                </div>
                            <div class="modal-footer">
                                <button type="submit" name="btnDeclineRequest" class="btn btn-danger">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php } ?>
            <hr>
      </div>
    </div>
  </div>

</div>



<?php include_once("./components/footscript.php"); ?>