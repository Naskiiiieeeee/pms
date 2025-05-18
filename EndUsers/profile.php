<?php 
include_once("./components/header.php");
include_once("./components/sidebar.php");
include_once("./components/innernavbar.php");
include_once(__DIR__ . "/../connection/config.php");
$con = connection();

?>
<!-- Page Content  -->
<h2 class="mb-4">Forms</h2>

<div class="row">
  
  <div class="col-lg-6 md-3">
    <div class="card">
        <?php if ($notification): ?>
            <div class="notification <?= $notificationType ?>">
                <?php echo htmlspecialchars($notification); ?>
            </div>
        <?php endif; ?>
      <div class="card-body">
            <center>
                <img src="./images/bsu.jpg" alt="Profile" height="100px" width="100px" class="rounded-circle">
                <h3><?= $role; ?></h3>
            </center>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email / Username</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" value="<?= $username; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Fullname</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" value="<?= $fullname; ?>" readonly>
                </div>
            </form>
      </div>
    </div>
  </div>

  <div class="col-lg-6 md-3">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><i class="fas fa-plus"></i> Update Password</h5>
            <form action="action.php" method="post" id="registerForm">
                <div class="mb-3">
                    <input type="hidden" class="form-control" name="username" value="<?= $username; ?>" readonly>
                    <label>Password</label>
                    <input type="password" id="password" name="password" class="form-control" required oninput="checkPasswordMatch()" />
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" id="confirm_password" class="form-control" required oninput="checkPasswordMatch()" />
                    <div id="passwordFeedback" class="invalid-feedback" style="display:none;">
                        Passwords do not match.
                    </div>
                </div>
                <div class="mb-3">
                    <button class="btn btn-success rounded" id="registerBtn" type="submit" name="btnUpdateUserPassword"><i class="fas fa-save"></i> Save</button>
                </div>

            </form>
      </div>
    </div>
  </div>

</div>

<script>
    function toggleForm(form) {
    document.getElementById('login-form').style.display = form === 'login' ? 'block' : 'none';
    document.getElementById('register-form').style.display = form === 'register' ? 'block' : 'none';
    }

    function toggleLoginPassword() {
    const loginPass = document.getElementById("login-password");
    loginPass.type = loginPass.type === "password" ? "text" : "password";
    }

  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirm_password");
  const registerBtn = document.getElementById("registerBtn");
  const feedback = document.getElementById("passwordFeedback");

  function checkPasswordMatch() {
    if (password.value === confirmPassword.value && password.value !== "") {
      confirmPassword.classList.remove("is-invalid");
      confirmPassword.classList.add("is-valid");
      feedback.style.display = "none";
      registerBtn.disabled = false;
    } else {
      confirmPassword.classList.remove("is-valid");
      confirmPassword.classList.add("is-invalid");
      feedback.style.display = "block";
      registerBtn.disabled = true;
    }
  }
</script>


<?php include_once("./components/footscript.php"); ?>