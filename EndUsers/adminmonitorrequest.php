<?php 
include_once("./components/header.php");
include_once("./components/sidebar.php");
include_once("./components/innernavbar.php");
include_once(__DIR__ . "/../connection/config.php");
$con = connection();

?>
<h2 class="mb-4">Manage Request</h2>

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
                <th scope="col">Department/Branch</th>
                <th scope="col">Request By</th>
                <th scope="col">Date Needed</th>
                <th scope="col">Date Posted</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
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
    
                      $search = mysqli_query($con, "SELECT COUNT(*) as total_records FROM `request` WHERE `statusOne` = 0  ORDER BY `r_id` DESC")
                      or die(mysqli_errno($con));
    
                      $records = mysqli_fetch_array($search);
    
                      $total_records = $records['total_records'];
    
                      $total_no_of_pages = ceil($total_records / $total_records_per_page);

                    $getUsersInfo = mysqli_query($con,"SELECT * FROM `request` WHERE `statusOne` = 0 ORDER BY `r_id` DESC LIMIT $offset , $total_records_per_page");
                    while($row = mysqli_fetch_assoc($getUsersInfo)){
                      $userID = $row['empID'];
                    ?>
                  <tr>
                    <td><?php echo $count++;?></td>
                    <td><?= $row['transactionCode']; ?></td>
                    <?php 
                    $seletDep = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$userID'");
                    while($fetch = mysqli_fetch_assoc($seletDep)){
                    ?>
                    <td class=""><?=  $fetch['department'];?> ( <?=  $fetch['campus'];?> ) </td>
                    <td><?=  $fetch['fullname'];?></td>
                    <?php                        
                    } ?>
                    <td><?=  $row['dateNeeded'];?></td>
                    <td><?=  $row['dateRequest'];?></td>

                    <td>
                      <?php
                        if ($row['statusOne'] == 0 ) {
                          echo '<span class="badge bg-warning text-white p-2"><i class="fa fa-exclamation-triangle"></i> PENDING </span>';
                        } else {
                          echo '<span class="badge bg-success p-2"><i class="fa fa-check-circle"></i> VERIFIED </span>';
                        }
                      ?>
                    </td>
                    <td>
                      <a href="adminviewunitRequest.php?ID=<?php echo $row['transactionCode']?>" class="btn btn-sm btn-secondary mt-1 p-1"><i class="fa fa-eye mx-2" data-toggle="tooltip" title="Request"></i> </a>
                      <button type="button" class="btn btn-danger mt-1 p-1 btn-sm deleteRequest" id="<?= $row['transactionCode'] ?>"><i class="fa fa-trash-o mx-2" aria-hidden="true"></i> </button>
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

<script>
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".deleteRequest").forEach(button => {
    button.addEventListener("click", function () {
      const transactionCode = this.id;

      if (confirm("Are you sure you want to delete this request?")) {
        fetch("action.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: "transactionCode=" + encodeURIComponent(transactionCode),
        })
        .then(response => response.text())
        .then(result => {
          alert(result);
          location.reload(); 
        })
        .catch(error => {
          console.error("Error:", error);
          alert("Something went wrong.");
        });
      }
    });
  });
});
</script>



<?php include_once("./components/footscript.php"); ?>