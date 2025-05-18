<?php 
include_once("./components/header.php");
include_once("./components/sidebar.php");
include_once("./components/innernavbar.php");
include_once(__DIR__ . "/../connection/config.php");
$con = connection();

?>
<!-- Page Content  -->
<h2 class="mb-4">Pick Up Package</h2>

<div class="row">
  
  <div class="col-lg-12 md-3">
    <div class="card">
        <?php if ($notification): ?>
            <div class="notification <?= $notificationType ?>">
                <?php echo htmlspecialchars($notification); ?>
            </div>
        <?php endif; ?>
      <div class="card-body">
        <h5 class="card-title">Recent Records</h5>
        <div class="table-responsive">
          <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Transaction ID</th>
                    <th scope="col">Products</th>
                    <th scope="col">Quantities</th>
                    <th scope="col">Request By:</th>
                    <th scope="col">Date Arrive</th>
                    <th scope="col">Status</th>
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
    
                      $search = mysqli_query($con, "SELECT COUNT(*) as total_records FROM `orderconfirmation` WHERE `empID` = '$username' ORDER BY `oc_id` DESC")
                      or die(mysqli_errno($con));
    
                      $records = mysqli_fetch_array($search);
    
                      $total_records = $records['total_records'];
    
                      $total_no_of_pages = ceil($total_records / $total_records_per_page);

                    $getUsersInfo = mysqli_query($con,"SELECT * FROM `orderconfirmation` WHERE `empID` = '$username' ORDER BY `oc_id` DESC LIMIT $offset , $total_records_per_page");
                    while($row = mysqli_fetch_assoc($getUsersInfo)){
                    ?>
                  <tr>
                    <td><?php echo $count++;?></td>
                    <td class="id"><?= $row['orderID']; ?></td>
                    <td class="">
                        <?php
                                $imploded_data = $row['products'];
                                $exploded_price = explode(",", $imploded_data);
                                
                                foreach ($exploded_price as $value) {
                                    echo "• ".$value."<br>";
                                }
                            ?>
                    </td>
                    <td class="">
                        <?php
                                $imploded_data = $row['quantities'];
                                $exploded_price = explode(",", $imploded_data);
                                
                                foreach ($exploded_price as $value) {
                                    echo "• ".$value."<br>";
                                }
                            ?>
                    </td>
                    <td class="">
                        <?php
                           $username = $row['empID'];
                           $selectUser = mysqli_query($con,"SELECT * FROM `users` WHERE `username` = '$username'");
                           $data = mysqli_fetch_assoc($selectUser);
                           echo $data['fullname'];
                        ?>
                    </td>
                    <td class=""><?=  $row['datePosted'];?></td>
                    <td>
                      <?php
                        if ($row['status'] == 0 ) {
                          echo '<span class="badge bg-secondary text-white p-2"><i class="fa fa-exclamation-triangle"></i> Ready to Pick-Up </span>';
                        } else {
                          echo '<span class="badge bg-success text-white p-2"><i class="fa fa-check-circle"></i> Received </span>';
                        }
                      ?>
                    </td>
                  </tr>
                  <?php }?>
            </tbody>
          </table>
          <div class="card-footer bg-bg-info-subtle d-flex align-items-center justify-content-between">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center fw-bold">
                        <li class="page-item <?php if($page_no <= 1) echo 'disabled'; ?>">
                            <a class="page-link" href="?page_no=1">First</a>
                        </li>
                        <li class="page-item <?php if($page_no <= 1) echo 'disabled'; ?>">
                            <a class="page-link" href="<?php if($page_no <= 1){ echo '#'; } else { echo "?page_no=".($page_no - 1); } ?>">Prev</a>
                        </li>
                        <li class="page-item <?php if($page_no >= $total_no_of_pages) echo 'disabled'; ?>">
                            <a class="page-link" href="<?php if($page_no >= $total_no_of_pages){ echo '#'; } else { echo "?page_no=".($page_no + 1); } ?>">Next</a>
                        </li>
                        <li class="page-item <?php if($page_no >= $total_no_of_pages) echo 'disabled'; ?>">
                            <a class="page-link" href="?page_no=<?php echo $total_no_of_pages; ?>">Last</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once("./components/footscript.php"); ?>