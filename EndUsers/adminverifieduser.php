<?php 
include_once("./components/header.php");
include_once("./components/sidebar.php");
include_once("./components/innernavbar.php");
include_once(__DIR__ . "/../connection/config.php");
$con = connection();

?>
<!-- Page Content  -->
<h2 class="mb-4">Manage Users</h2>

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
                    <th scope="col">Access ID</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Department</th>
                    <th scope="col">Access</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
            <tbody>
            <?php 
                    $count = 1;
                    $getUsersInfo = mysqli_query($con,"SELECT * FROM `users` WHERE `status` = 1 OR `status` = 2  ORDER BY `user_id` DESC");
                    while($row = mysqli_fetch_assoc($getUsersInfo)){
                    ?>
                  <tr>
                    <td><?php echo $count++;?></td>
                    <td class="id"><?= $row['username']; ?></td>
                    <td class="fname"><?=  $row['fullname'];?></td>
                    <td><?=  $row['department'] ?? "<span class='badge bg-danger mx-1 p-2 fs-4 text-white'> Not Specified</span>";?></td>
                    <td class="job"><?=  $row['access'];?></td>
                    <td>
                      <?php
                        if ($row['status'] == 1 ) {
                          echo '<span class="badge bg-success p-2 text-white"><i class="fa fa-check-circle"></i> VERIFIED </span>';
                        }else if ($row['status'] == 2 ) {
                          echo '<span class="badge bg-danger text-white p-2"><i class="fa fa-exclamation-triangle"></i> RESTRICTED </span>';
                        } else {
                          echo '<span class="badge bg-secondary text-white p-2"><i class="fa fa-exclamation-triangle"></i> NOT APPROVED </span>';
                        }
                      ?>
                    </td>
                    <td>
                      <button type="button" class="btn btn-sm btn-success mt-1 p-1 editbutton" data-bs-toggle="modal" data-bs-target="#verifyModal">
                        <i class="fa fa-check-square-o mx-2" data-toggle="tooltip" title="VERIFY"></i>
                      </button>
                      <button type="button" class="btn btn-danger mt-1 p-1 btn-sm deleteUsers" id="<?= $row['user_id'] ?>"><i class="fa fa-trash-o mx-2" aria-hidden="true"></i> </button>
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

        <!-- Modal -->
    <div class="modal fade" id="verifyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="action.php" method="post">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h4 class="modal-title fs-5 fw-bold" id="exampleModalLabel"><i class="fa fa-user-plus" aria-hidden="true"></i> Manage Users Access</h4>
                    </div>
                    <div class="modal-body">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Access ID</label>
                                <input type="text" name="id" class="form-control" id="id" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">User Full Name</label>
                                <input type="text" name="fname" class="form-control" id="fname" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Access Description</label>
                                <select name="access" id="" class="form-control">
                                  <option selected disabled>Please Select</option>
                                  <option value="1">Verified</option>
                                  <option value="2">Restricted</option>
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times-circle-o" aria-hidden="true"></i>  Close</button>
                        <button type="submit" name="btnUpdateUsersAccess" class="btn btn-success"><i class="fa fa-check-square-o" aria-hidden="true"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
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
                    success: function(response){
                        if(response === "protected"){
                            Swal.fire({
                                title: 'Blocked',
                                icon: 'info',
                                text: 'This account is protected and cannot be deleted.',
                                timer: 2500
                            });
                        } else if(response === "deleted"){
                            Swal.fire({
                                title: 'Deleted!',
                                icon: 'success',
                                text: 'User deleted successfully',
                                timer: 2000
                            }).then(()=>{ window.location.reload(); });
                        } else if(response === "nouser"){
                            Swal.fire("Not Found","No user found!","error");
                        } else {
                            Swal.fire("Error","Something went wrong.","error");
                        }
                    }
                });
            }
        })
    })
})
</script>


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




<?php include_once("./components/footscript.php"); ?>