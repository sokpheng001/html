<?php 
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require_once __DIR__ . '/../../vendor/autoload.php';
    require_once __DIR__. '/environment.php';  // Send email function
    require_once __DIR__ . '/mail_template.php';
    

    function sendMail($to, $subject, $email, $password): void {
        global $sender_email, $email_app_pass;
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Use your mail server
            $mail->SMTPAuth = true;
            $mail->Username = $sender_email;
            $mail->Password = $email_app_pass; // Use App Password, NOT your real password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email headers
            $mail->setFrom($sender_email, 'IT Department');
            $mail->addAddress($to);
            $mail->Subject = $subject;

            // HTML email body with inline styles (email and password)
            $message = getMailForm($email, $password);

            // Set the content type to HTML
            $mail->isHTML(true);
            $mail->Body = $message;

            // Send the email
            $mail->send();
            echo 'Email sent successfully!';
        } catch (Exception $e) {
            echo "Email sending failed: {$mail->ErrorInfo}";
        }
    }
    ob_end_flush();
?>
