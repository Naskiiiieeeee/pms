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
<h2 class="mb-4">Add New Users</h2>

<div class="row">
  
  <div class="col-lg-12 md-3">
    <div class="card">
      <div class="card-body">
        <?php if ($notification): ?>
            <div class="notification <?= $notificationType ?>">
                <?php echo htmlspecialchars($notification); ?>
            </div>
        <?php endif; ?>
        <h5 class="card-title"><i class="fas fa-plus"></i></h5>
            <form action="action.php" method="post" enctype="multipart/form-data">
                <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Fullname</label>
                    <div class="col-md-8 col-lg-9">
                    <input name="fullname" type="text" class="form-control" required>
                    </div>
                </div>

                
                <div class="row mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">Access Description</label>
                    <div class="col-md-8 col-lg-9">
                        <select name="job" class="col-md-8 col-lg-9 form-control" required>
                            <option selected disabled  class="fw-bold">SELECT</option>
                            <option value="Admin">Administrator</option>
                            <option value="DepHead">Department Head</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="dep"  class="col-md-4 col-lg-3 col-form-label">Campus</label>
                    <div class="col-md-8 col-lg-9">
                        <select name="dep" id="dep" class="form-control">
                            <option selected disabled>SELECT CAMPUS</option>
                            <option value="BSU ALANGILAN">BSU ALANGILAN</option>
                            <option value="BSU NASUGBO">BSU NASUGBO</option>
                            <option value="BSU MALVAR">BSU MALVAR</option>
                            <option value="BSU LOBO">BSU LOBO</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="department"  class="col-md-4 col-lg-3 col-form-label">Department</label>
                    <div class="col-md-8 col-lg-9">
                        <select name="department" id="department" class="form-control">
                            <option selected disabled>SELECT DEPARTMENT</option>
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
  function toggleForm(form) {
    document.getElementById('login-form').style.display = form === 'login' ? 'block' : 'none';
    document.getElementById('register-form').style.display = form === 'register' ? 'block' : 'none';
  }
          document.addEventListener("DOMContentLoaded", function() {
            const departments = {
                "BSU ALANGILAN": [
                    "COLLEGE OF ENGINEERING, ARCHITECTURE AND FINE ARTS",
                    "COLLEGE OF INDUSTRIAL TECHNOLOGY",
                    "COLLEGE OF INFORMATICS AND COMPUTING SCIENCES/ INFORMATION TECHNOLOGY & COMPUTER SCIENCES"
                ],
                "BSU NASUGBO": [
                    "COLLEGE OF TEACHER EDUCATION",
                    "COLLEGE OF ACCOUNTANCY, BUSINESS, ECONOMICS AND INTERNATIONAL HOSPITALITY MANAGEMENT",
                    "COLLEGE OF INFORMATICS AND COMPUTING SCIENCES",
                    "COLLEGE OF ARTS AND SCIENCES",
                    "COLLEGE OF HEALTH SCIENCES",
                    "COLLEGE OF CRIMINAL JUSTICE EDUCATION",
                    "LABORATORY SCHOOL"
                ],
                "BSU MALVAR": [
                    "COLLEGE OF ENGINEERING TECHNOLOGY / COLLEGE OF INDUSTRIAL TECHNOLOGY",
                    "COLLEGE OF TEACHER EDUCATION",
                    "COLLEGE OF ENGINEERING",
                    "COLLEGE OF INFORMATICS AND COMPUTING SCIENCES",
                    "COLLEGE OF ARTS AND SCIENCES",
                    "COLLEGE OF ACCOUNTANCY, BUSINESS, ECONOMICS AND INTERNATIONAL HOSPITALITY MANAGEMENT"
                ],
                "BSU LOBO": [
                    "COLLEGE OF AGRICULTURE AND FORESTRY"
                ]
            };

            const campusDropdown = document.getElementById("dep");
            const departmentDropdown = document.getElementById("department");

            campusDropdown.addEventListener("change", function() {
                const selectedCampus = this.value;
                departmentDropdown.innerHTML = '<option selected disabled>SELECT DEPARTMENT</option>'; 

                if (departments[selectedCampus]) {
                    departments[selectedCampus].forEach(department => {
                        let option = document.createElement("option");
                        option.value = department;
                        option.textContent = department;
                        departmentDropdown.appendChild(option);
                    });
                }
            });
        });
</script>




<?php include_once("./components/footscript.php"); ?>