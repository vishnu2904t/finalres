<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars($_POST["phone"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    if (!$email) {
        die("Invalid email format.");
    }

    require 'vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'aaoverseasenterprises@gmail.com'; // Use environment variable
        $mail->Password = 'tybsphjgvbfqwcpu'; // Use environment variable
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email details
        $mail->setFrom('aaoverseasenterprises@gmail.com', 'Website Contact Form');
        $mail->addAddress('aaoverseasenterprises@gmail.com');
        $mail->addReplyTo($email, $name);
        $mail->Subject = "New Contact Form Message from $name";
        $mail->Body = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\nMessage: $message\n";

        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Error sending message: {$mail->ErrorInfo}";
    }
}
?>

