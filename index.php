<?php
session_start();
$notification = $_SESSION['notification'] ?? '';
$notificationType = $_SESSION['notification_type'] ?? 'success'; 
unset($_SESSION['notification'], $_SESSION['notification_type']);
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

    <?php if ($notification): ?>
         <div class="notification <?= $notificationType ?>">
            <?php echo htmlspecialchars($notification); ?>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <div id="login-form">
      <h3 class="text-center">PMS - Login</h3>
    <form action="action.php" method="POST">
        <div class="mb-3">
            <label>Email address</label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" id="login-password" name="password" class="form-control" required />
            <div class="form-check mt-1">
            <input type="checkbox" class="form-check-input" id="showLoginPassword" onclick="toggleLoginPassword()">
            <label class="form-check-label" for="showLoginPassword">Show Password</label>
            </div>
        </div>
        <div class="mb-2">
          <a href="forgetpassword.php" class=" text-dark ">Forget Password?</a>
        </div>
        <button type="submit" name="btnLogin" class="btn btn-primary w-100"> <i class="fas fa-arrow-right"></i> Login</button>
    </form>
      <p class="mt-3 text-center">
        Don't have an account?
        <span class="toggle-link" onclick="toggleForm('register')">Register here</span>
      </p>
    </div>

    <!-- Register Form -->
    <div id="register-form" style="display: none;">
      <h3 class="text-center">PMS - Register</h3>
        <form action="action.php" method="POST" id="registerForm">
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="fullname" class="form-control" required />
            </div>

            <div class="mb-3">
                <label>Email address</label>
                <input type="email" name="email" class="form-control" required />
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" id="password" name="password" class="form-control" required />
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input type="password" id="confirm_password" class="form-control" required />
                <div id="passwordFeedback" class="invalid-feedback">
                   Passwords do not match.
                </div>
            </div>

            <div class="mb-3">
                <label>Access Role</label>
                <select name="role" id="" class="form-control" required>
                    <option selected disabled>Please Choose</option>
                    <option value="Admin">Administrator</option>
                    <option value="Dephead">Department</option>
                </select>
            </div>
                        
            <div class="mb-3">
                <label for="dep">Campus</label>
                <select name="dep" id="dep" class="form-control" required>
                    <option selected disabled>SELECT CAMPUS</option>
                    <option value="BSU ALANGILAN">BSU ALANGILAN</option>
                    <option value="BSU NASUGBO">BSU NASUGBO</option>
                    <option value="BSU MALVAR">BSU MALVAR</option>
                    <option value="BSU LOBO">BSU LOBO</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="department">Department</label>
                <select name="department" id="department" class="form-control" required>
                    <option selected disabled>SELECT DEPARTMENT</option>
                </select>
            </div>

            <button type="submit" name="btnRegister" id="registerBtn" class="btn btn-success w-100" disabled><i class="fas fa-plus"></i> Register</button>
        </form>
      <p class="mt-3 text-center">
        Already have an account?
        <span class="toggle-link" onclick="toggleForm('login')">Login here</span>
      </p>
    </div>
  </div>


    <!--Notification Box-->
    <script>
      setTimeout(() => {
          const box = document.querySelector('.notification');
          if (box) {
              box.style.opacity = '0';
              setTimeout(() => box.style.display = 'none', 500);
          }
      }, 5000);
    </script>

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

  password.addEventListener("input", checkPasswordMatch);
  confirmPassword.addEventListener("input", checkPasswordMatch);

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

</body>
</html>
