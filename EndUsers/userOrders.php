<?php 
include_once("./components/header.php");
include_once("./components/sidebar.php");
include_once("./components/innernavbar.php");
include_once(__DIR__ . "/../connection/config.php");
$con = connection();

?>
<!-- Page Content  -->
<h2 class="mb-4">Order Status</h2>

<div class="row">
  
  <div class="col-lg-12 md-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Recent Records</h5>
        <div class="table-responsive">
          <table class="table table-striped-columns">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Transaction Code</th>
                <th scope="col">Purpose For Request</th>
                <th scope="col">Order Status</th>
                <th colspan="2">Action</th>
                </tr>
            </thead>
                <tbody>
                  <?php 
                      if(isset($_GET['page_no']) && $_GET['page_no'] !== ""){
                        $page_no = $_GET['page_no'];
                      }else{
                          $page_no = 1; 
                      }
                      
                      $total_records_per_page = 5; 
                      $offset = ($page_no - 1) * $total_records_per_page;
                      $count = $offset + 1;
                      $previous_page = $page_no - 1;
                      $next_page = $page_no + 1;
    
                      $search = mysqli_query($con, "SELECT COUNT(*) as total_records FROM `request` WHERE `empID` = '$username' ORDER BY `r_id` DESC")
                      or die(mysqli_errno($con));
    
                      $records = mysqli_fetch_array($search);
    
                      $total_records = $records['total_records'];
    
                      $total_no_of_pages = ceil($total_records / $total_records_per_page);

                    $getUsersInfo = mysqli_query($con,"SELECT * FROM `request` WHERE `empID` = '$username' ORDER BY `r_id` DESC LIMIT $offset , $total_records_per_page");
                    while($row = mysqli_fetch_assoc($getUsersInfo)){
                    ?>
                    <tr>
                        <td><?php echo $count++;?></td>
                        <td><?= $row['transactionCode']; ?></td>
                        <td><?=  $row['Reason'];?></td>
                        <td>
                            <?php
                                if ($row['statusTwo'] == 0 ) {
                                echo '<span class="badge bg-secondary text-white p-2"><i class="fa fa-exclamation-triangle"></i> PENDING </span>';
                                }elseif($row['statusTwo'] == 2){
                                    echo '<span class="badge bg-danger text-white p-2"><i class="fa fa-exclamation-triangle"></i> DECLINE </span>';
                                } else {
                                echo '<span class="badge bg-success p-2 text-white"><i class="fa fa-check-circle"></i> ORDERED </span>';
                                }
                            ?>
                        </td>
                        <td>
                            <a href="userviewOrder.php?ID=<?php echo $row['transactionCode'];?>" class="btn btn-primary text-white p-2 btn-sm  mx-2"><i class="fas fa-eye"></i> View</a>
                        </td>
                    </tr>
                  <?php }?>
                </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



<?php include_once("./components/footscript.php"); ?>