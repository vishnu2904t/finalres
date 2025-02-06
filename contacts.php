<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    require 'PHPMailer/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'aaoverseasenterprises@gmail.com'; // Your Gmail address
        $mail->Password = 'tybs phjg vbfq wcpu'; // Your App Password (remove spaces)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email details
        $mail->setFrom($email, $name);
        $mail->addAddress('aaoverseasenterprises@gmail.com'); // Your Gmail to receive messages
        $mail->Subject = "New Contact Form Message from $name";
        $mail->Body = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\nMessage: $message\n";

        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Error sending message: {$mail->ErrorInfo}";
    }
}
?>