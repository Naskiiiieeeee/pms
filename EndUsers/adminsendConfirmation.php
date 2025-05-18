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
            <?php if ($notification): ?>
                <div class="notification <?= $notificationType ?>">
                    <?php echo htmlspecialchars($notification); ?>
                </div>
            <?php endif; ?>
            <center>
                <img src="./images/bsu.jpg" alt="Profile" height="100px" width="100px" class="rounded-circle">
                <h2>Purchased Order Arrival Form</h2>
            </center>
            <hr>
            <hr>
            <?php 
                // Fetching transaction details from the database
                $transaction_id = $_GET['ID'];
                $query = "SELECT * FROM `orders` WHERE `orderID` = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("s", $transaction_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while($data = $result->fetch_assoc()){
                    $userID = $data['empID'];
                    $orderID = $data['orderID'];
                    $products = $data['addSupply'];
                    $quantity = $data['quantity'];
            ?>
            <form action="action.php" method="post">
                            <div class="form-group">
                                <label for="">Message Description</label>
                                <textarea name="messageContent" class="form-control" rows="10">Good Day Ma`am/Sir, we would like to inform you that your purchase order has been arrived at the supply department. The supply department can check first the item if it is correct before the supplier send to your office/department. 
                                Thank you. 
                                </textarea>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="empID" value="<?= $userID ?>">
                                <input type="hidden" name="products" value="<?= $products ?>">
                                <input type="hidden" name="quantities" value="<?= $quantity ?>">
                                <input type="hidden" name="orderID" value="<?= $orderID ?>">
                            </div>
                            <div>
                                <button type="submit" name="btnSendConfirmation" class="btn btn-success p-1 mt-2"><i class="fas fa-paper-plane"></i> Send</button>
                            </div>
                    </form>
            <?php } ?>
            <hr>
      </div>
    </div>
  </div>

</div>



<?php include_once("./components/footscript.php"); ?>