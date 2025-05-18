<?php 
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
            <form action="action.php" method="post" id="add_form">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Reason for Requesting</label>
                    <input name="Reason" type="text" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                    <textarea  name="Description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Date Request</label>
                    <input name="dateRequest" type="date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Product Information</label>
                    <div class="add_supply_wrapper">
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
                                <button class="btn btn-success add_item_btn" type="button">
                                    <span class="icon"><i class="fas fa-plus"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Date Need</label>
                    <input name="dateNeeded" type="date" class="form-control" required>
                    <input name="empID" type="hidden" class="form-control" value="<?= $username; ?>" required>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="btnSaveRequest"><i class="fa fa-floppy-o" aria-hidden="true"></i> Request Now</button>
                </div>
            </form>
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