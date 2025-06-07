<?php 
session_start();
include_once(__DIR__ . "/./connection/config.php");
include_once(__DIR__ . "/./Methods/classes.php");

$insertUser = new insertUser();
$con = connection();

if(isset($_POST['btnRegister'])){
    
    $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);

    $dep = htmlspecialchars($_POST['dep'] ?? "");
    $department = htmlspecialchars($_POST['department'] ?? "");


    $pass = password_hash($password, PASSWORD_BCRYPT);

    if($role == "Admin"){
        $response = $insertUser->adminUser($con, $fullname,$email,$pass,$role);

        $_SESSION['notification'] = $response['message'];
        $_SESSION['notification_type'] = $response['type'];

        echo "<script>window.location.href = 'index.php';</script>";

    }else{
        $response = $insertUser->depheadUser($con, $fullname,$email,$pass,$dep,$department, $role);
        $_SESSION['notification'] = $response['message'];
        $_SESSION['notification_type'] = $response['type'];

        echo "<script>window.location.href = 'index.php';</script>";
    }
}

if (isset($_POST['btnLogin'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $status = 1;

    $selectUser = "SELECT * FROM `users` WHERE `username` = ? AND `status` = ?";
    $stmt = $con->prepare($selectUser);
    $stmt->bind_param("ss", $email,$status);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['fullname'] = $user['fullname']; 
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['access'];
                header("location: ./EndUsers/dashboard.php");
                exit();
            } else {
                $_SESSION['notification'] = "Invalid password!";
                $_SESSION['notification_type'] = "error";
                echo "<script>window.location.href = 'index.php';</script>";
                exit();
            }
        } else {
            $_SESSION['notification'] = "No username found!";
            $_SESSION['notification_type'] = "error";
            echo "<script>window.location.href = 'index.php';</script>";
            exit();
        }
    } else {
        echo "Error executing query: " . $stmt->error;
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnForgetPassword'])){
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    try
    {
        if($response = $insertUser->ForgetPassword($con,$email)){
            $_SESSION['notification'] = $response['message'];
            $_SESSION['notification_type'] = $response['type'];
        }else{
            $_SESSION['notification'] = $response['message'];
            $_SESSION['notification_type'] = $response['type'];
        }

    } catch (Exception $e) {
        $_SESSION['notification'] = $e->getMessage();
        $_SESSION['notification_type'] = "error";
    }
    echo "<script>window.location.href = 'index.php';</script>";
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnUpdatePassword'])){

    $code = filter_input(INPUT_POST,"code",FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);

    try{
        if($response = $insertUser->getUpdateUserPassword($con, $email,$password,$code)){
            $_SESSION['notification'] = $response['message'];
            $_SESSION['notification_type'] = $response['type'];
        }else{
            $_SESSION['notification'] = $response['message'];
            $_SESSION['notification_type'] = $response['type'];
        }
    } catch (Exception $e) {
        $_SESSION['notification'] = $e->getMessage();
        $_SESSION['notification_type'] = "error";
    }

    echo "<script>window.location.href = 'index.php';</script>";
    exit;

}


?>
