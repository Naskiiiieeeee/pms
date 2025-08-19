<?php 

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include_once(__DIR__ . "/../connection/config.php");
$con = connection();

class insertUser {
    public function adminUser($con, $fullname, $email, $password, $role) {

        $selectUserifExist = "SELECT * FROM `users` WHERE `username` = ?";
        $selectUserSTMT = $con->prepare($selectUserifExist);
        $selectUserSTMT->bind_param("s", $email);
        $selectUserSTMT->execute();
        $result = $selectUserSTMT->get_result();

        if ($result->num_rows > 0) {
            return [
                'message' => "Duplicate User Information!",
                'type' => 'error'
            ];
        } else {
            $stmt = $con->prepare("INSERT INTO `users` (`fullname`, `username`, `password`, `access`) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssss", $fullname, $email, $password, $role);
                if ($stmt->execute()) {
                    return [
                        'message' => "Admin user successfully added.",
                        'type' => 'success'
                    ];
                } else {
                    return [
                        'message' => "Error executing statement: " . $stmt->error,
                        'type' => 'error'
                    ];
                }
            } else {
                return [
                    'message' => "Error preparing statement: " . $con->error,
                    'type' => 'error'
                ];
            }
        }
    }

    public function ForgetPassword($con, $emailTo)
    {
        $mail = new PHPMailer(true);
        $code = uniqid(true);

        $query = "INSERT INTO `resetpassword`(`code`, `username`) VALUES (?,?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss",$code,$emailTo);

        if (!$stmt->execute()) {
            return [
                'message' => 'Database error while generating reset code.',
                'type' => 'error'
            ];
        }

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tamuni.vents@gmail.com';
            $mail->Password   = 'mhjvrevblevchuop';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('tamuni.vents@gmail.com', 'ProcurementMS');
            $mail->addAddress($emailTo);
            $mail->isHTML(true);
            $mail->Subject = 'ProcurementMS Password Reset';

            $imagePath = __DIR__ . '/../EndUsers/images/bsu.jpg';
            $cid = 'bocs_logo'; 

            if (file_exists($imagePath)) {
                $mail->addEmbeddedImage($imagePath, $cid, 'logo.png');
            }
            $url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/resetpassword.php?code=$code";
                $mail->Body = '
                <div style="font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; color: #333;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img src="cid:' . $cid . '" alt="BOCS Logo" style="height: 100px;"><br>
                        <h2>Password Reset Request</h2>
                    </div>

                    <p>Hello ' . htmlspecialchars($emailTo) . ',</p>

                    <p>We received a request to reset your password. If this was you, please click the button below to proceed:</p>

                    <div style="text-align: center; margin: 20px 0;">
                        <a href="' . $url . '" style="display: inline-block; background-color: #333; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 4px;">
                            Reset My Password
                        </a>
                    </div>

                    <p>If you didn’t request this, you can safely ignore this email.</p>

                    <p>Best regards,<br><strong>ProcurementMS Team</strong></p>

                    <hr style="border: none; border-top: 1px solid #ccc; margin: 30px 0;">
                    <small style="color: #999;">This is an automated message. Please do not reply.</small>
                </div>';

            $mail->send();
            return [
                'message' => 'Reset password link has been sent to your email. Kindly check it.',
                'type' => 'success'
            ];
        } catch (Exception $e) {
            return [
                'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}",
                'type' => 'error'
            ];
        }
    }

    public function getUpdateUserPassword($con, $email, $pass,$code){

        $hashed_password = password_hash($pass, PASSWORD_BCRYPT);

        $updatePassword = "UPDATE `users` SET `password` = ? WHERE `username` = ? ";
        $updateSTMT = $con->prepare($updatePassword);
        $updateSTMT->bind_param("ss",$hashed_password,$email);
        if (!$updateSTMT->execute()) {
            throw new Exception("Failed to insert user: " . $updateSTMT->error);
        }else{
            $deleteUserFrom = "DELETE FROM `resetpassword` WHERE `code` = ? ";
            $deleteStmt = $con->prepare($deleteUserFrom);
            $deleteStmt->bind_param('s',$code);
            $deleteStmt->execute();
        }
        return ['message' => "Password Updated Successfully!", 'type' => 'success'];
    }


    public function depheadUser($con, $fullname, $email, $password, $campus, $department, $role) {
        $selectUserifExist = "SELECT * FROM `users` WHERE `username` = ? ";
        $selectUserSTMT = $con->prepare($selectUserifExist);
        $selectUserSTMT->bind_param("s",$email);
        $selectUserSTMT->execute();
        $result = $selectUserSTMT->get_result();

        if($result->num_rows > 0){
            return [
                'message' => "Duplicate User Information!",
                'type' => 'error'
            ];
        }else{
            $stmt = $con->prepare("INSERT INTO `users` (`fullname`, `username`, `password`, `campus`, `department`, `access`) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssssss", $fullname, $email, $password, $campus, $department, $role);
                if ($stmt->execute()) {
                    return [
                        'message' => "Department Head successfully added.",
                        'type' => 'success'
                    ];
                } else {
                    return [
                        'message' => "Error executing statement: " . $stmt->error,
                        'type' => 'error'
                    ];
                }
            } else {
                return [
                    'message' => "Error preparing statement: " . $con->error,
                    'type' => 'error'
                ];
            }
        }
    }

    public function newUserInfo($con, $fullname, $email, $password, $campus, $department, $role) {
        $selectUserifExist = "SELECT * FROM `users` WHERE `username` = ? ";
        $selectUserSTMT = $con->prepare($selectUserifExist);
        $selectUserSTMT->bind_param("s",$email);
        $selectUserSTMT->execute();
        $result = $selectUserSTMT->get_result();

        if($result->num_rows > 0){
            return [
                'message' => "Duplicate User Information!",
                'type' => 'error'
            ];
        }else{
            $stmt = $con->prepare("INSERT INTO `users` (`fullname`, `username`, `password`, `campus`, `department`, `access`) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssssss", $fullname, $email, $password, $campus, $department, $role);
                if ($stmt->execute()) {
                    return [
                        'message' => "New user successfully added.",
                        'type' => 'success'
                    ];
                } else {
                    return [
                        'message' => "Error executing statement: " . $stmt->error,
                        'type' => 'error'
                    ];
                }
            } else {
                return [
                    'message' => "Error preparing statement: " . $con->error,
                    'type' => 'error'
                ];
            }
        }
    }

}

class SystemOperators{
    public function sendRequest($empID, $content, $qty, $date) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tamuni.vents@gmail.com';
            $mail->Password = 'mhjvrevblevchuop';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tamuni.vents@gmail.com', 'ProcurementMS');
            $mail->addAddress($empID);
            $mail->isHTML(true); // Enable HTML

            $mail->Subject = 'Your Purchase Request Summary';

            $mail->Body = '
            <div style="font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9;">
                <h2 style="color: #333;">📦 Purchase Request Confirmation</h2>
                <p>Dear User,</p>
                <p>Thank you for submitting your request. Here are the details:</p>

                <table cellpadding="10" cellspacing="0" style="border: 1px solid #ccc; background: #fff; border-collapse: collapse;">
                    <tr style="background-color: #f1f1f1;">
                        <th style="border: 1px solid #ccc;">Product</th>
                        <th style="border: 1px solid #ccc;">Quantity</th>
                        <th style="border: 1px solid #ccc;">Date Needed</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ccc;">' . htmlspecialchars($content) . '</td>
                        <td style="border: 1px solid #ccc;">' . htmlspecialchars($qty) . '</td>
                        <td style="border: 1px solid #ccc;">' . htmlspecialchars($date) . '</td>
                    </tr>
                </table>

                <p style="margin-top: 20px;">We will notify you once your request is processed. If you have any questions, feel free to reply to this email.</p>

                <p>Best regards,<br><strong>ProcurementMS Team</strong></p>
                <hr>
                <small style="color: #888;">This is an automated message. Please do not reply directly.</small>
            </div>';

            if (!$mail->send()) {
                return [
                    'message' => "Message could not be sent. Mailer Error: " . $mail->ErrorInfo,
                    'type' => 'error'
                ];
            } else {
                return [
                    'message' => "Request posted and email sent successfully!",
                    'type' => 'success'
                ];
            }
        } catch (Exception $e) {
            return [
                'message' => "Message could not be sent. Exception: {$mail->ErrorInfo}",
                'type' => 'error'
            ];
        }
    }
    public function generateNextTransactionCode($con) {
        $query = "SELECT transactionCode FROM `request` ORDER BY r_id DESC LIMIT 1";
        $result = $con->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lastCode = $row['transactionCode'];
        } else {
            $lastCode = "000"; // starting point
        }
        $lastNumber = intval($lastCode);
        $nextNumber = $lastNumber + 1;
        $nextCode = str_pad($nextNumber, 3, "0", STR_PAD_LEFT);
        return $nextCode;
    }

    public function generateTransactionCodeForOrder($con){
        $query = "SELECT `orderID` FROM `orders` ORDER BY `o_id` DESC LIMIT 1";
        $result = $con->query($query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $lastCode = $row['orderID'];
        } else {
            $lastCode = "00"; // starting point
        }

        $lastNumber = intval($lastCode);
        $nextNumber = $lastNumber + 1;

        // 2 digits lang, leading zero kung below 10
        $nextCode = str_pad($nextNumber, 2, "0", STR_PAD_LEFT);

        return $nextCode;
    }

    public function randomStringGenerator($length, $characters){
        $randomString = '';
        $charlength = strlen($characters);
        for($increment = 0; $increment < $length ; $increment++){
            $randomString .= $characters[rand(0, $charlength - 1)];
        }
        return $randomString;
        }
    public function emailBlocker($validEmail, $emailExtension){
        if(strpos($validEmail, $emailExtension) === false){
            echo "<script>alert('Invalid Email Domain');</script>";
            echo "<script>window.location='index.php';</script>";
        exit;
        }
        }

    public function sendOrder($empID, $orderID) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tamuni.vents@gmail.com';
            $mail->Password = 'mhjvrevblevchuop';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tamuni.vents@gmail.com', 'ProcurementMS');
            $mail->addAddress($empID);
            $mail->isHTML(true); // Enable HTML
            $mail->Subject = 'Your Purchase Order Has Been Approved!';

            $mail->Body = '
            <div style="font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9;">
                <h2 style="color: #2c3e50;">Purchase Order Confirmation</h2>
                <p style="font-size: 16px;">Dear User,</p>

                <p style="font-size: 15px; color: #333;">
                    We are pleased to inform you that your <strong>Purchase Request</strong> has been approved!
                </p>

                <table style="margin-top: 15px; width: 100%; border: 1px solid #ccc; border-collapse: collapse;">
                    <tr style="background-color: #f1f1f1;">
                        <th style="padding: 10px; border: 1px solid #ccc; text-align: left;">Order ID</th>
                        <td style="padding: 10px; border: 1px solid #ccc;">' . htmlspecialchars($orderID) . '</td>
                    </tr>
                    <tr>
                        <th style="padding: 10px; border: 1px solid #ccc; text-align: left;">Status</th>
                        <td style="padding: 10px; border: 1px solid #ccc;">Approved</td>
                    </tr>
                </table>

                <p style="margin-top: 20px; font-size: 14px;">
                    Please log in to your <a href="http://localhost/pms" style="color: #007bff;">Procurement Portal</a> to view the full details and next steps.
                </p>

                <p style="margin-top: 30px; font-size: 14px;">
                    Best regards,<br>
                    <strong>ProcurementMS Team</strong>
                </p>

                <hr style="margin-top: 40px;">
                <p style="font-size: 12px; color: #888;">This is an automated message. Please do not reply directly to this email.</p>
            </div>';

            if (!$mail->send()) {
                echo '
                <script>
                    alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");
                </script>';
            } else {
                    return [
                        'message' => "Order posted and email sent successfully!",
                        'type' => 'success'
                    ];
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function sendDeclineOrder($empID, $RequestID) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tamuni.vents@gmail.com';
            $mail->Password = 'mhjvrevblevchuop';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tamuni.vents@gmail.com', 'ProcurementMS');
            $mail->addAddress($empID);
            $mail->isHTML(true);
            $mail->Subject = 'Purchase Request Declined';

            $mail->Body = '
            <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                <h2 style="color: #c0392b;">Purchase Request Declined</h2>
                <p style="font-size: 16px;">Dear Department Head,</p>
                
                <p style="font-size: 15px; color: #333;">
                    We regret to inform you that your purchase request with the following details has been declined:
                </p>

                <table style="margin-top: 15px; width: 100%; border: 1px solid #ddd; border-collapse: collapse;">
                    <tr style="background-color: #f2f2f2;">
                        <th style="padding: 10px; border: 1px solid #ccc;">Request ID</th>
                        <td style="padding: 10px; border: 1px solid #ccc;">' . htmlspecialchars($RequestID) . '</td>
                    </tr>
                    <tr>
                        <th style="padding: 10px; border: 1px solid #ccc;">Status</th>
                        <td style="padding: 10px; border: 1px solid #ccc; color: #e74c3c;"><strong>Declined</strong></td>
                    </tr>
                </table>

                <p style="margin-top: 20px; font-size: 14px;">
                    Reason: <em>This request did not meet the necessary requirements for the purchasing process.</em>
                </p>

                <p style="margin-top: 20px; font-size: 14px;">
                    Please review your request in the <a href="http://localhost/pms" style="color: #007bff;">Procurement Portal</a> and feel free to make the necessary adjustments or reach out to the procurement team for further clarification.
                </p>

                <p style="margin-top: 30px; font-size: 14px;">
                    Sincerely,<br>
                    <strong>ProcurementMS Team</strong>
                </p>

                <hr style="margin-top: 40px;">
                <p style="font-size: 12px; color: #888;">This is an automated message. Please do not reply directly to this email.</p>
            </div>';

            if (!$mail->send()) {
                echo '
                <script>
                alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");
                </script>';
            } else {
                    return [
                        'message' => "Order posted and email sent successfully!",
                        'type' => 'success'
                    ];
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function sendConfirmationOrder($empEmail, $orderID) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tamuni.vents@gmail.com';
            $mail->Password = 'mhjvrevblevchuop'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            
            $mail->setFrom('tamuni.vents@gmail.com', 'ProcurementMS');
            $mail->addAddress($empEmail);
            
            $mail->Subject = 'Your Purchase Order Has Arrived (Order ID: ' . $orderID . ')';

            $mail->isHTML(true);
            
            $htmlBody = '
                <div style="font-family: Arial, sans-serif; padding: 20px; color: #333;">
                    <h2 style="color: #007BFF;">Your Order is Ready for Pickup!</h2>
                    <p>Good day,</p>
                    <p>We would like to inform you that your purchase order has <strong>arrived at our office</strong>.</p>
                    <p><strong>Order ID:</strong> ' . htmlspecialchars($orderID) . '</p>
                    <p>Please pick up your package as soon as possible.</p>
                    <p style="margin-top: 30px;">Thank you,<br><strong>Procurement Management System</strong></p>
                </div>
            ';

            $plainBody = "Your purchase order has arrived at our office.\n\nOrder ID: $orderID\n\nPlease pick up your package as soon as possible.\n\nThank you,\nProcurementMS";

            $mail->Body = $htmlBody;
            $mail->AltBody = $plainBody;

            if (!$mail->send()) {
                return [
                    'message' => "Message could not be sent. Mailer Error: " . $mail->ErrorInfo,
                    'type' => 'error'
                ];
            } else {
                return [
                    'message' => "Purchase Order Package email sent successfully!",
                    'type' => 'success'
                ];
            }
        } catch (Exception $e) {
            return [
                'message' => "Mailer Exception: {$mail->ErrorInfo}",
                'type' => 'error'
            ];
        }
    }

}

?>