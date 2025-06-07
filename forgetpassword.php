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
      <h3 class="text-center">PMS - Forget Password</h3>
    <form action="action.php" method="POST">
        <div class="mb-3">
            <label>Email address</label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-2">
          <a href="index.php" class=" text-dark ">Back to Login</a>
        </div>
        <button type="submit" name="btnForgetPassword" class="btn btn-primary w-100"> <i class="fas fa-arrow-right"></i> Submit</button>
    </form>
    </div>
  </div>

<script>
    setTimeout(() => {
        const box = document.querySelector('.notification');
        if (box) {
            box.style.opacity = '0';
            setTimeout(() => box.style.display = 'none', 500);
        }
    }, 5000);
</script>


</body>
</html>
