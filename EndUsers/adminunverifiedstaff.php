<?php 
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['fullname']) || !isset($_SESSION['role'])) {
    '<script>alert("Unauthorized access!"); window.location = "index.php";</script>';
    exit;
}
$notification = $_SESSION['notification'] ?? '';
$notificationType = $_SESSION['notification_type'] ?? 'success'; 
unset($_SESSION['notification'], $_SESSION['notification_type']);

$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];
$role = $_SESSION['role'];

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
                    $access = "Dephead";
                    $getUsersInfo = mysqli_query($con,"SELECT * FROM `users` WHERE `status` = 0  AND `access` = '$access'");
                    while($row = mysqli_fetch_assoc($getUsersInfo)){
                    ?>
                  <tr>
                    <td><?php echo $count++;?></td>
                    <td class="id"><?= $row['username']; ?></td>
                    <td class="fname"><?=  $row['fullname'];?></td>
                    <td><?=  $row['department'];?></td>
                    <td class="job"><?=  $row['access'];?></td>
                    <td>
                      <?php
                        if ($row['status'] == 0 ) {
                          echo '<span class="badge bg-secondary text-white p-2"><i class="fa fa-exclamation-triangle"></i> NOT APPROVED </span>';
                        } else {
                          echo '<span class="badge bg-success p-2"><i class="fa fa-check-circle"></i> VERIFIED </span>';
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
                        <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel"><i class="fa fa-user-plus" aria-hidden="true"></i> Verify Users Account</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Access ID</label>
                                <input type="text" name="id" class="form-control" id="id">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">User Full Name</label>
                                <input type="text" name="fname" class="form-control" id="fname">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Access Description</label>
                                <input type="text" name="job" class="form-control" id="job">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times-circle-o" aria-hidden="true"></i>  Close</button>
                        <button type="submit" name="btnUpdateUsers" class="btn btn-success"><i class="fa fa-check-square-o" aria-hidden="true"></i>Verify Account</button>
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