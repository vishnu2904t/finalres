<?php
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Ensure no other output before JSON response
ob_clean();
header('Content-Type: application/json');

// Load environment variables
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $response = array();
        
        $name = htmlspecialchars($_POST["name"] ?? '');
        $email = filter_var($_POST["email"] ?? '', FILTER_VALIDATE_EMAIL);
        $phone = htmlspecialchars($_POST["phone"] ?? '');
        $subject = htmlspecialchars($_POST["subject"] ?? '');
        $message = htmlspecialchars($_POST["message"] ?? '');

        if (!$email) {
            throw new Exception('Invalid email format.');
        }

        $mail = new PHPMailer(true);
        
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email details
        $mail->setFrom('aaoverseasenterprises@gmail.com', 'Website Contact Form');
        $mail->addAddress('aaoverseasenterprises@gmail.com');
        $mail->addReplyTo($email, $name);
        $mail->Subject = "New Contact Form Message from $name";
        $mail->Body = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\nMessage: $message\n";

        if($mail->send()) {
            $response = [
                'status' => 'success',
                'message' => 'Message sent successfully'
            ];
        } else {
            throw new Exception('Failed to send message');
        }
        
    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
    }
    
    echo json_encode($response);
    exit;
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
    exit;
}
?>

