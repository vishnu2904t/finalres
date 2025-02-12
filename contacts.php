<?php
ob_start(); // Start output buffering at the very beginning

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars($_POST["phone"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    if (!$email) {
        die("Invalid email format.");
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'aaoverseasenterprises@gmail.com'; // Use environment variable
        $mail->Password = 'tybsphjgvbfqwcpu'; // Use environment variable
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Set email to use HTML
        $mail->isHTML(true);
        
        // Email details
        $mail->setFrom('aaoverseasenterprises@gmail.com', 'Website Contact Form');
        $mail->addAddress('aaoverseasenterprises@gmail.com');
        $mail->addReplyTo($email, $name);
        $mail->Subject = "New Contact Form Message from $name";
        
        // Create HTML email body with logo and styling
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <div style='padding: 20px; background-color: #f8f9fa;'>
                <img src='https://finalres.onrender.com/images/logo-black.png' alt='AA Overseas Enterprises Logo' style='width: 150px; height: auto; margin-bottom: 20px;'>
                
                <div style='background-color: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);'>
                    <h2 style='color: #333; margin-bottom: 20px;'>New Contact Form Submission</h2>
                    
                    <table style='width: 100%; border-collapse: collapse;'>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; width: 100px;'><strong>Name:</strong></td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'>$name</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'><strong>Email:</strong></td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'>$email</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'><strong>Phone:</strong></td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'>$phone</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'><strong>Subject:</strong></td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee;'>$subject</td>
                        </tr>
                    </table>
                    
                    <div style='margin-top: 20px;'>
                        <strong>Message:</strong><br>
                        <div style='background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 10px;'>
                            " . nl2br($message) . "
                        </div>
                    </div>
                </div>
                
                <div style='margin-top: 20px; font-size: 12px; color: #666; text-align: center;'>
                    This email was sent from the contact form on AA Overseas Enterprises website.
                </div>
            </div>
        </div>";
        
        // Create plain text version for email clients that don't support HTML
        $mail->AltBody = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\nMessage: $message";

        if($mail->send()){
            ob_end_clean(); // Clear the output buffer
            header("Location: index.html");
            exit();
        } else {
            echo "Error sending message";
        }
    } catch (Exception $e) {
        echo "Error sending message: ".$mail->ErrorInfo;
    }
} else {
    echo "Invalid request.";
}
ob_end_flush(); // Flush the output buffer at the end
?>

