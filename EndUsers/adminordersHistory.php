<?php 
include_once("./components/header.php");
include_once("./components/sidebar.php");
include_once("./components/innernavbar.php");
include_once(__DIR__ . "/../connection/config.php");
$con = connection();

?>
<!-- Page Content  -->
<h2 class="mb-4">Manage Orders History</h2>

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
                <th scope="col">Request ID</th>
                <th scope="col">Date Approved</th>
                <th scope="col">Date Needed</th>
                <th scope="col">Department/Branch</th>
                <th scope="col">Request By:</th>
                <th scope="col">Order Status</th>
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
                      $total_records_per_page = 4;
                      $offset = ($page_no - 1) * $total_records_per_page;
                      $count = $offset + 1;
                      $previous_page = $page_no - 1;
                      $next_page = $page_no + 1;
    
                      $search = mysqli_query($con, "SELECT COUNT(*) as total_records FROM `orders` WHERE `status` != 3 ORDER BY `o_id` DESC")
                      or die(mysqli_errno($con));
    
                      $records = mysqli_fetch_array($search);
    
                      $total_records = $records['total_records'];
    
                      $total_no_of_pages = ceil($total_records / $total_records_per_page);

                    $getUsersInfo = mysqli_query($con,"SELECT * FROM `orders` WHERE `status` != 3  ORDER BY `o_id` DESC LIMIT $offset , $total_records_per_page");
                    while($row = mysqli_fetch_assoc($getUsersInfo)){
                      $userID = $row['empID'];
                    ?>
                  <tr>
                        <td><?php echo $count++;?></td>
                        <td class=""><?= $row['orderID']; ?></td>
                        <td class=""><?= $row['requestID']; ?></td>
                        <td class=""><?=  $row['datePosted'];?></td>
                        <td class=""><?=  $row['dateNeeded'];?></td>
                            <?php 
                            $seletSup = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$userID'");
                            while($fetch = mysqli_fetch_assoc($seletSup)){
                            ?>
                            <td class=""><?=  $fetch['department'];?> ( <?=  $fetch['campus'];?> ) </td>
                            <td class=""><?=  $fetch['fullname'];?></td>
                            <?php                        
                            } 
                            ?>
                        <td>
                            <?php
                                if ($row['status'] == 0 ) {
                                echo '<span class="badge bg-warning text-white p-2"><i class="fa fa-exclamation-triangle"></i> PENDING </span>';
                                }elseif ($row['status'] == 2 ) {
                                    echo '<span class="badge bg-danger text-white p-2"><i class="fa fa-exclamation-triangle"></i> DECLINED </span>';
                                }
                                else {
                                echo '<span class="badge bg-success p-2 text-white"><i class="fa fa-check-circle"></i> APPROVED </span>';
                                }
                            ?>
                        </td>
                        <td>
                            <a href="adminviewunitOrderHistory.php?ID=<?php echo $row['orderID']?>" class="btn btn-sm btn-secondary mt-1 p-1 "><div class="pb-1"><i class="fas fa-eye mx-2" data-toggle="tooltip" title="Request"></i></div> </a>
                            <button type="button" class="btn btn-sm btn-danger mt-1 p-1 archieveOrders" id="<?= $row['orderID'] ?>" title="Archieve"><i class="fas fa-trash mx-2"></i> </button>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function(){
        $(document).on('click','.deleteRequest',function(){
            var id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url: 'action.php',
                    type: 'POST',
                    data: {deleteRequestA:id},
                    success: function(data){
                    Swal.fire({
                        title: 'Success',
                        icon: 'success',
                        text: ' Request Information Deleted Succesfully',
                        showConfirmButton: false,
                        timer: 2000,
                    }).then(()=>{
                        window.location.reload();
                    })
                    }
                })
                }
            })
        })
        })
    </script>


<?php include_once("./components/footscript.php"); ?>