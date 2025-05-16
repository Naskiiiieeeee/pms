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
<h2 class="mb-4">Request Form</h2>

<div class="row">
  
  <div class="col-lg-12 md-3">
    <div class="card">
      <div class="card-body">
        <?php if ($notification): ?>
            <div class="notification <?= $notificationType ?>">
                <?php echo htmlspecialchars($notification); ?>
            </div>
        <?php endif; ?>
        <h5 class="card-title"><i class="fas fa-plus"></i> Add New</h5>
            <form action="action.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Fullname</label>
                    <div class="col-md-8 col-lg-9">
                    <input name="fullname" type="text" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="about" class="col-md-4 col-lg-3 col-form-label">Address</label>
                    <div class="col-md-8 col-lg-9">
                    <textarea name="address" class="form-control" id="about" style="height: 100px" required></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="Address" class="col-md-4 col-lg-3 col-form-label">Phone Number</label>
                    <div class="col-md-8 col-lg-9">
                    <input name="pnumber" type="number" class="form-control" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">Access Description</label>
                    <div class="col-md-8 col-lg-9">
                    <select name="job" class="col-md-8 col-lg-9 form-control" required>
                    <option value="" class="fw-bold">SELECT</option>
                    <option value="Admin">Administrator</option>
                    <option value="DepHead">Department Head</option>
                    </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">* if you choosen Department Head *</label>
                    <div class="col-md-8 col-lg-9">
                    <select name="dep" class="col-md-8 col-lg-9 form-control ">
                    <option value="" class="fw-bold">SELECT</option>
                    <option value="ICS">Institute of Computer Studies</option>
                    <option value="IOB">Institute of Business Adminstration</option>
                    <option value="IOE">Institute of Education</option>
                    <option value="Others">Others</option>
                    </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Username:</label>
                    <div class="col-md-8 col-lg-9">
                    <input name="empID" type="text" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Password:</label>
                    <div class="col-md-8 col-lg-9">
                    <input name="pw" type="text" class="form-control" required>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="btnSaveUser"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save User Information</button>
                </div>
            </form><!-- End Profile Edit Form -->
      </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $(".add_item_btn").click(function (e) {
            e.preventDefault();
            $(".add_supply_wrapper").append(`
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <input type="text" name="addSupply[]" class="form-control" placeholder="Product name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" name="productDes[]" class="form-control" placeholder="Description" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type="number" name="quantity[]" class="form-control" placeholder="Qty" required>
                    </div>
                    <div class="col-md-1 mb-3 d-grid">
                        <button class="btn btn-danger remove_item_btn" type="button">
                            <span class="icon"><i class="fas fa-minus"></i></span>
                        </button>
                    </div>
                </div>
            `);
        });

        $(document).on('click', '.remove_item_btn', function (e) {
            e.preventDefault();
            $(this).closest('.row').remove();
        });
    });
</script>




<?php include_once("./components/footscript.php"); ?>