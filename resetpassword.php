<?php
session_start();
include_once(__DIR__ . "/./connection/config.php");
$con = connection();

if (!isset($_GET["code"])) {
    exit("Page in the link does not exist!");
}

$codes = $_GET["code"];
$getEmailQuery = mysqli_query($con, "SELECT `username` FROM `resetpassword` WHERE `code` = '$codes'");

if (mysqli_num_rows($getEmailQuery) > 0) {
    $row = mysqli_fetch_assoc($getEmailQuery);
    $userAccount = $row['username'];
} else {
    $userAccount = "";
    echo "Access Invalid. ";
}

if (mysqli_num_rows($getEmailQuery) == 0) {
    exit("Page not exist!");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Procurement System</title>
  <link rel="shortcut icon" href="EndUsers/images/bsu.jpg" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-image:linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.3)), url("EndUsers/images/bsu.jpg");
      background-repeat: no-repeat;
      background-size: contain;
      background-position: center;
    }

    .auth-card {
      max-width: 500px;
      width: 100%;
      padding: 30px;
      background-color: #fff;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .auth-card h3 {
      margin-bottom: 20px;
    }

    .toggle-link {
      font-size: 0.9rem;
      cursor: pointer;
      color: #007bff;
    }

    .toggle-link:hover {
      text-decoration: underline;
    }
    h3{
        font-family: 'Times New Roman', Times, serif;
        font-size: xx-large;
    }
   .notification {
        padding: 15px;
        margin: 20px;
        border-radius: 5px;
        font-weight: bold;
        transition: opacity 0.5s ease-out;
    }

    .notification.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .notification.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
  </style>

</head>
<body>

  <div class="auth-card">
    <!-- Login Form -->
    <div id="login-form">
      <h3 class="text-center">PMS - Create New Password</h3>
    <form action="action.php" method="POST">
        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" required />
            <input type="hidden" name="code" value="<?= $codes; ?>">
            <input type="hidden" name="email" value="<?= $userAccount; ?>">
        </div>
        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="Confirmpassword" class="form-control" required />
            <small id="matchMessage" class="form-text"></small>
        </div>
        <div class="mb-2">
          <a href="index.php" class=" text-dark ">Back to Login</a>
        </div>
        <button type="submit" name="btnUpdatePassword" class="btn btn-primary w-100"> <i class="fas fa-arrow-right"></i> Submit</button>
    </form>
    </div>
  </div>


<script>
  const password = document.querySelector('input[name="password"]');
  const confirmPassword = document.querySelector('input[name="Confirmpassword"]');
  const submitBtn = document.querySelector('button[name="btnUpdatePassword"]');
  const matchMessage = document.getElementById('matchMessage');

  const checkbox = document.createElement('div');
  checkbox.innerHTML = `
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="showPassCheck">
      <label class="form-check-label" for="showPassCheck">Show Password</label>
    </div>
  `;
  confirmPassword.parentElement.insertAdjacentElement('afterend', checkbox);

  document.getElementById('showPassCheck').addEventListener('change', function () {
    const type = this.checked ? 'text' : 'password';
    password.type = type;
    confirmPassword.type = type;
  });

  function validatePasswordMatch() {
    if (password.value === "" && confirmPassword.value === "") {
      matchMessage.textContent = "";
      submitBtn.disabled = true;
      return;
    }

    if (password.value === confirmPassword.value) {
      matchMessage.textContent = "Passwords match.";
      matchMessage.style.color = "green";
      submitBtn.disabled = false;
    } else {
      matchMessage.textContent = "Passwords do not match.";
      matchMessage.style.color = "red";
      submitBtn.disabled = true;
    }
  }

  password.addEventListener('input', validatePasswordMatch);
  confirmPassword.addEventListener('input', validatePasswordMatch);

  submitBtn.disabled = true;
</script>


</body>
</html>
