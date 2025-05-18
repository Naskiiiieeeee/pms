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
                    <th scope="col">Date Approved</th>
                    <th scope="col">Department/Branch</th>
                    <th scope="col">Request By:</th>
                    <th scope="col">Date Arrive</th>
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
                    $total_records_per_page = 3; // Change this to the number of records per page you want
                    $offset = ($page_no - 1) * $total_records_per_page;
                    $count = $offset + 1;
                    $previous_page = $page_no - 1;
                    $next_page = $page_no + 1;

                    $search = mysqli_query($con, "SELECT COUNT(*) as total_records FROM `orderconfirmation` WHERE `status` = 1 ORDER BY `oc_id` DESC")
                    or die(mysqli_errno($con));
                    $records = mysqli_fetch_array($search);
                    $total_records = $records['total_records'];
                    $total_no_of_pages = ceil($total_records / $total_records_per_page);

                    $getUsersInfo = mysqli_query($con,"SELECT * FROM `orderconfirmation`  WHERE `status` = 1 ORDER BY `oc_id` DESC LIMIT $offset , $total_records_per_page");
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
                    <td class=""><?=  $row['datePosted'];?></td>
                      <?php
                        $username = $row['empID'];
                        $selectUser = mysqli_query($con,"SELECT * FROM `users` WHERE `username` = '$username'");
                        while($data = mysqli_fetch_assoc($selectUser)){
                      ?>
                        <td class=""><?=  $data['department'];?> ( <?=  $data['campus'];?> ) </td>
                        <td class=""><?=  $data['fullname'];?></td>
                      <?php 
                       }
                      ?>
                    <td class=""><?=  $row['datePosted'];?></td>
                    <td>
                      <?php
                        if ($row['status'] == 0 ) {
                          echo '<span class="badge bg-secondary text-white p-2"><i class="fa fa-exclamation-triangle"></i> Ready to Pick-Up </span>';
                        } else {
                          echo '<span class="badge bg-success p-2 mt-1"><i class="fa fa-check-circle"></i> Recieved </span>';
                        }
                      ?>
                    </td>
                    <td>
                      <button type="button" class="btn btn-sm btn-success mt-1 p-1 editbutton" data-bs-toggle="modal" data-bs-target="#verifyModal">
                        <i class="fa fa-check-square-o mx-2" data-toggle="tooltip" title="Action"></i>
                      </button>
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


        <!-- Modal -->
    <div class="modal fade" id="verifyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="action.php" method="post">
            <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h4 class="modal-title fs-5 fw-bold" id="exampleModalLabel"><i class="fa fa-box" aria-hidden="true"></i> Verify Package Arrival</h4>
            </div>
            <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Access ID</label>
                        <input type="text" name="orderID" class="form-control" id="id" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Remarks</label>
                        <select name="remarks" id="" class="form-control">
                            <option disabled selected>Please Select</option>
                            <option value="1">Pick-Up Package</option>
                            <option value="0">Re-assess</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times-circle-o" aria-hidden="true"></i>  Close</button>
                <button type="submit" name="btnPickup" class="btn btn-success"><i class="fa fa-check-square-o" aria-hidden="true"></i> Post</button>
            </div>
            </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.editbutton').click(function() {
                var $row = $(this).closest('tr');
                var id = $row.find('.id').text();
                var fname = $row.find('.fname').text();
                var job = $row.find('.job').text();

                $('#id').val(id);
                $('#fname').val(fname);
                $('#job').val(job);

                $('#verifyModal').modal('show');
            });
        });
    </script>

    <script>
    $(document).ready(function(){
    $(document).on('click','.deleteUsers',function(){
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
                data: {deleteUsers:id},
                success: function(data){
                Swal.fire({
                    title: 'Success',
                    icon: 'success',
                    text: ' Users Information Deleted Succesfully',
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