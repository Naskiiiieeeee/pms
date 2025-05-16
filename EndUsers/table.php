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
<h2 class="mb-4">Table</h2>

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
                <th scope="col">Access ID</th>
                <th scope="col">Full Name</th>
                <th scope="col">Department</th>
                <th scope="col">Access</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



<?php include_once("./components/footscript.php"); ?>