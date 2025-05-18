<?php 
session_start();
include_once(__DIR__ . "/../connection/config.php");
include_once(__DIR__ . "/../Methods/classes.php");

$insertUser = new insertUser();
$SystemOperators = new SystemOperators();

if (isset($_POST['btnSaveRequest'])) {
  $transactionCode = $SystemOperators->generateNextTransactionCode($con); 
  $Reason = filter_input(INPUT_POST, 'Reason', FILTER_SANITIZE_SPECIAL_CHARS);
  $Description = filter_input(INPUT_POST, 'Description', FILTER_SANITIZE_SPECIAL_CHARS);

  $addSupply = implode(",", $_POST['addSupply']);
  $productDes = implode(",", $_POST['productDes']);
  $quantity = implode(",", $_POST['quantity']);

  $dateNeeded = filter_input(INPUT_POST, 'dateNeeded', FILTER_SANITIZE_SPECIAL_CHARS);
  $dateRequest = filter_input(INPUT_POST, 'dateRequest', FILTER_SANITIZE_SPECIAL_CHARS);
  $empID = filter_input(INPUT_POST, 'empID', FILTER_SANITIZE_SPECIAL_CHARS);

  $insertRequest = "INSERT INTO `request`(`transactionCode`, `Reason`, `Description`, `addSupply`, `productDes`, `quantity`,  `dateNeeded`, `dateRequest`, `empID`) 
                    VALUES (?,?,?,?,?,?,?,?,?)";
  $insertRequestStmt = $con->prepare($insertRequest);
  $insertRequestStmt->bind_param("sssssssss", $transactionCode, $Reason, $Description, $addSupply, $productDes, $quantity,  $dateNeeded, $dateRequest, $empID);

  if ($insertRequestStmt->execute()) {
        $response = $SystemOperators->sendRequest($empID, $addSupply, $quantity, $dateNeeded);
        $_SESSION['notification'] = $response['message'];
        $_SESSION['notification_type'] = $response['type'];
        echo "<script>window.location.href = 'requestnow';</script>";

  } else {
        $_SESSION['notification'] = "Error in executing data!";
        $_SESSION['notification_type'] = "error";
        echo "<script>window.location.href = 'requestnow';</script>";
  }
}

if(isset($_POST['btnDeclineRequest'])){
  $transcode = filter_input(INPUT_POST, 'transcode', FILTER_SANITIZE_SPECIAL_CHARS);
  $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);
  $statusOne = 2;
  $declineRequest = "UPDATE `request` SET `statusOne` = ? , `notes` = ? WHERE `transactionCode` = ?";
  $declineRequestStmt = $con->prepare($declineRequest);

  $declineRequestStmt->bind_param("iss",$statusOne,$notes,$transcode);
  if($declineRequestStmt->execute()){
      $_SESSION['notification'] = "Request Has Been Declined";
      $_SESSION['notification_type'] = "error";
      echo "<script>window.location.href = 'adminmonitorrequest';</script>";
  }else{
    echo $declineRequestStmt->error;
  }
}

if(isset($_POST['btnApprovedRequest'])){
  $transcode = filter_input(INPUT_POST, 'transcode', FILTER_SANITIZE_SPECIAL_CHARS);
  $statusOne = 1;
  $dateApprove = date('Y-m-d');
  $approvedRequest = "UPDATE `request` SET `statusOne` = ? , `dateApprove` = ? WHERE `transactionCode` = ?";
  $approvedRequestStmt = $con->prepare($approvedRequest);

  $approvedRequestStmt->bind_param("iss",$statusOne,$dateApprove, $transcode);
  if($approvedRequestStmt->execute()){
      $_SESSION['notification'] = "Request Has Been Approved";
      $_SESSION['notification_type'] = "success";
      echo "<script>window.location.href = 'adminmonitorrequest';</script>";
  }else{
    echo $approvedRequestStmt->error;
  }
}

if(isset($_POST['deleteRequestA'])){
  $id = filter_input(INPUT_POST, 'deleteRequestA', FILTER_SANITIZE_SPECIAL_CHARS);
  $sql = "DELETE FROM `request` WHERE `transactionCode` = '$id'";
  $query = $con->query($sql) or die ($con->error);

  if($query){
      '<script>
          window.location = "monitorRequest.php"; 
       </script>';
  }
}


if(isset($_POST['btnPostOrder'])){


  $orderID = $SystemOperators->generateNextTransactionCode($con); 
  $status = 1;
  $statusOne = 0;
  $transcode = filter_input(INPUT_POST, 'transcode', FILTER_SANITIZE_SPECIAL_CHARS);
  $empID = filter_input(INPUT_POST, 'empID', FILTER_SANITIZE_SPECIAL_CHARS);
  $Reason = filter_input(INPUT_POST, 'Reason', FILTER_SANITIZE_SPECIAL_CHARS);
  $addSupply = filter_input(INPUT_POST, 'addSupply', FILTER_SANITIZE_SPECIAL_CHARS);
  $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS);
  $dateNeeded = filter_input(INPUT_POST, 'dateNeeded', FILTER_SANITIZE_SPECIAL_CHARS);
  $supplier = filter_input(INPUT_POST, 'supplier', FILTER_SANITIZE_SPECIAL_CHARS);


 $datePosted = date('Y-m-d');

 $selectRequestCode = "SELECT * FROM `orders` WHERE `requestID` = ?";
 $selectRequestStmt = $con->prepare($selectRequestCode);
 $selectRequestStmt->bind_param("s", $transcode);

 if($selectRequestStmt->execute()){
      $results = $selectRequestStmt->get_result();
      if($results->num_rows > 0){
        echo '<script> alert("Duplicate Purchased Order!"); window.location = "adminmonitororder.php"; </script>';
      }else{
          $checkIfStatusOneis = "SELECT * FROM `request` WHERE `transactionCode` = ? AND `statusOne` = ?";
          $checkstatusOne = $con->prepare($checkIfStatusOneis);
          $checkstatusOne->bind_param("si",$transcode,$statusOne);
          if($checkstatusOne->execute()){
            $resultsOne =  $checkstatusOne->get_result();
            if($resultsOne->num_rows > 0){
                echo 
                '
                  <script> alert("Transaction to be confirm first in Request Panel! Please try again!"); window.location="adminmonitororder.php";</script>
                ';
            }else{
              $insertOrder = "INSERT INTO `orders`(`orderID`, `requestID`, `empID`, `Reason`, `addSupply`, `quantity`, `dateNeeded`, `supplierID`,`status`,`datePosted`) VALUES
              (?,?,?,?,?,?,?,?,?,?)
              ";
              $inserOrderStmt = $con->prepare($insertOrder);
              $inserOrderStmt->bind_param("ssssssssss",$orderID,$transcode,$empID,$Reason,$addSupply,$quantity,$dateNeeded,$supplier,$status,$datePosted );
    
              if($inserOrderStmt->execute()){
                  $updateRequestStatusTwo = mysqli_query($con,"UPDATE `request` SET `statusTwo` = '$status' WHERE `transactionCode` = '$transcode' ");
                  $response = $SystemOperators->sendOrder($empID,$orderID);
                  $_SESSION['notification'] = $response['message'];
                  $_SESSION['notification_type'] = $response['type'];
                  echo "<script>window.location.href = 'adminmonitororder';</script>";
              }else{
                echo $inserOrderStmt->error;
              }
            }
          }else{
            echo "Error in binding parameters".$checkstatusOne->errno;
          }

      }
 }else{
  echo $selectRequestStmt->error;
 }
}

if(isset($_POST['btnUnpostOrder'])){

  $code = "0123456789";
  $limit = 15;
  $status = 2;
  $statusTwo = 2;

  $datePosted = date('Y-m-d');
  
  $orderID = $SystemOperators-> randomStringGenerator($limit,$code);
  $transcode = filter_input(INPUT_POST, 'transcode', FILTER_SANITIZE_SPECIAL_CHARS);
  $empID = filter_input(INPUT_POST, 'empID', FILTER_SANITIZE_SPECIAL_CHARS);
  $Reason = filter_input(INPUT_POST, 'Reason', FILTER_SANITIZE_SPECIAL_CHARS);
  $addSupply = filter_input(INPUT_POST, 'addSupply', FILTER_SANITIZE_SPECIAL_CHARS);
  $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS);
  $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS);
  $totalAmount = filter_input(INPUT_POST, 'totalAmount', FILTER_SANITIZE_SPECIAL_CHARS);
  $dateNeeded = filter_input(INPUT_POST, 'dateNeeded', FILTER_SANITIZE_SPECIAL_CHARS);
  $supplier = filter_input(INPUT_POST, 'supplier', FILTER_SANITIZE_SPECIAL_CHARS);
  
   $selectRequestCode = "SELECT * FROM `orders` WHERE `requestID` = ?";
   $selectRequestStmt = $con->prepare($selectRequestCode);
   $selectRequestStmt->bind_param("s", $transcode);
  
   if($selectRequestStmt->execute()){
        $results = $selectRequestStmt->get_result();
        if($results->num_rows > 0){
          echo '<script> alert("Duplicate Purchased Order!"); window.location = "monitorOrders.php"; </>';
        }else{
            $insertOrder = "INSERT INTO `orders`(`orderID`, `requestID`, `empID`, `Reason`, `addSupply`, `quantity`, `price`, `totalAmount`, `dateNeeded`, `supplierID`,`status`,`datePosted`) VALUES
            (?,?,?,?,?,?,?,?,?,?,?,?)
            ";
            $inserOrderStmt = $con->prepare($insertOrder);
            $inserOrderStmt->bind_param("ssssssssssss",$orderID,$transcode,$empID,$Reason,$addSupply,$quantity,$price,$totalAmount,$dateNeeded,$supplier,$status,$datePosted );
  
            if($inserOrderStmt->execute()){
              $updateRequestStatusTwo = mysqli_query($con,"UPDATE `request` SET `statusTwo` = '$statusTwo' WHERE `transactionCode` = '$transcode' ");
              $response = $SystemOperators-> sendDeclineOrder($empID, $transcode);
                  $_SESSION['notification'] = $response['message'];
                  $_SESSION['notification_type'] = $response['type'];
                  echo "<script>window.location.href = 'adminmonitororder';</script>";
            }else{
              echo $inserOrderStmt->error;
            }
        }
   }else{
    echo $selectRequestStmt->error;
   }
}

if(isset($_POST['btnSendConfirmation'])){
  $empID = filter_input(INPUT_POST, 'empID', FILTER_SANITIZE_SPECIAL_CHARS);
  $products = filter_input(INPUT_POST, 'products', FILTER_SANITIZE_SPECIAL_CHARS);
  $quantities = filter_input(INPUT_POST, 'quantities', FILTER_SANITIZE_SPECIAL_CHARS);
  $orderID = filter_input(INPUT_POST, 'orderID', FILTER_SANITIZE_SPECIAL_CHARS);
  $date = date("Y-m-d");

  $selectSentOrder = "SELECT * FROM `orderconfirmation` WHERE `orderID` = ?";
  $selectsentStmt = $con->prepare($selectSentOrder);
  $selectsentStmt->bind_param("s",$orderID);
  if($selectsentStmt->execute()){
      $results = $selectsentStmt->get_result();
      if($results->num_rows > 0){
        $_SESSION['notification'] = "Message Already Sent to Users Email Account";
        $_SESSION['notification_type'] = "error";
        echo "<script>window.location.href = 'adminordersHistory';</script>";
      }else{
        $insertMessage = "INSERT INTO `orderconfirmation`(`orderID`, `products`, `quantities`, `empID`, `datePosted`) VALUES (?,?,?,?,?)";
        $insertMessageStmt = $con->prepare($insertMessage);
        $insertMessageStmt->bind_param("sssss",$orderID,$products,$quantities,$empID,$date);
        if($insertMessageStmt->execute()){
          $response = $SystemOperators->sendConfirmationOrder($empID, $orderID);
          $_SESSION['notification'] = $response['message'];
          $_SESSION['notification_type'] = $response['type'];
          echo "<script>window.location.href = 'adminordersHistory';</script>";
        }else{
          echo $insertMessageStmt->error;
        }
      }
  }else{
    echo $selectsentStmt->error;
  }
}

if(isset($_POST['btnPickup'])){
  $orderID = filter_input(INPUT_POST, 'orderID', FILTER_SANITIZE_SPECIAL_CHARS);
  $remarks = filter_input(INPUT_POST, 'remarks', FILTER_SANITIZE_SPECIAL_CHARS);

  $updateArrivalConfirmation = "UPDATE `orderconfirmation` SET `status` = ? WHERE `orderID` = ? ";
  $arrivalStmt  = $con->prepare($updateArrivalConfirmation);
  $arrivalStmt->bind_param("is",$remarks,$orderID);
  if($arrivalStmt->execute()){
    echo"
    <script>alert('Order Confirmation Remarks has been updated!'); window.location='adminpickupOrders.php';</script>
    ";
  }else{
    echo $arrivalStmt->error;
  }
}


if(isset($_POST['btnSaveUser']))
{
  $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_SPECIAL_CHARS);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
  $pass = filter_input(INPUT_POST, 'pw', FILTER_SANITIZE_SPECIAL_CHARS);
  $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);

  $dep = htmlspecialchars($_POST['dep'] ?? "");
  $department = htmlspecialchars($_POST['department'] ?? "");

  $password = password_hash($pass, PASSWORD_BCRYPT);

  if($role == "Admin"){
      $response = $insertUser->adminUser($con, $fullname,$email,$password,$role);
      $_SESSION['notification'] = $response['message'];
      $_SESSION['notification_type'] = $response['type'];
      echo "<script>window.location.href = 'adminaddusers';</script>";
  }else{
      $response = $insertUser->depheadUser($con, $fullname,$email,$password,$dep,$department, $role);
      $_SESSION['notification'] = $response['message'];
      $_SESSION['notification_type'] = $response['type'];
      echo "<script>window.location.href = 'adminaddusers';</script>";
  }
}

if(isset($_POST['btnUpdateUsers'])){
  $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

  $status = 1;
  $updateUser = "UPDATE `users` SET `status` = ? WHERE `username` = ?";
  $updateUserSTMT = $con->prepare($updateUser);
  $updateUserSTMT->bind_param("ss",$status,$id);
  if($updateUserSTMT->execute()){
      $_SESSION['notification'] = "User Access Updated Successfully!";
      $_SESSION['notification_type'] = "success";

      echo "<script>window.location.href = 'adminverifieduser';</script>";
  }else{
      $_SESSION['notification'] = "Error in Executing Data!";
      $_SESSION['notification_type'] = "error";
      echo "<script>window.location.href = 'adminverifieduser';</script>";
  }
}

if(isset($_POST['btnUpdateUsersAccess'])){
  $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
  $access = filter_input(INPUT_POST, 'access', FILTER_SANITIZE_SPECIAL_CHARS);

  $updateUser = "UPDATE `users` SET `status` = ? WHERE `username` = ?";
  $updateUserSTMT = $con->prepare($updateUser);
  $updateUserSTMT->bind_param("ss",$access,$id);
  if($updateUserSTMT->execute()){
      $_SESSION['notification'] = "User Access Updated Successfully!";
      $_SESSION['notification_type'] = "success";

      echo "<script>window.location.href = 'adminverifieduser';</script>";
  }else{
      $_SESSION['notification'] = "Error in Executing Data!";
      $_SESSION['notification_type'] = "error";
      echo "<script>window.location.href = 'adminverifieduser';</script>";
  }
}



if(isset($_POST['deleteUsers'])){
  $id = filter_input(INPUT_POST, 'deleteUsers', FILTER_SANITIZE_SPECIAL_CHARS);
  $sql = "DELETE FROM `users` WHERE `user_id` = ?";
  $deleteUser = $con->prepare($sql);
  $deleteUser->bind_param("s", $id );
  if($deleteUser->execute()){
      '<script>
          window.location = "adminverifieduser"; 
       </script>';
  }else{
    echo "Error in executing Data".$deleteUser->errno;
  }
  $deleteUser->close();
  $con->close();
}