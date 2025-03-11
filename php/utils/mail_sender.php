<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once __DIR__ . '/../../vendor/autoload.php';

    function sendMail($to, $subject, $email, $password): void {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Use your mail server
            $mail->SMTPAuth = true;
            $mail->Username = "piu9066@gmail.com";
            $mail->Password = 'fnat dett bbpo gces'; // Use App Password, NOT your real password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email headers
            $mail->setFrom('piu9066@gmail.com', 'IT Department');
            $mail->addAddress($to);
            $mail->Subject = $subject;

            // HTML email body with inline styles (email and password)
            $message = '
                <!DOCTYPE html>
                <html lang="km">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Success Message</title>
                    <style>
                        :root {
                            --primary-color: #0a4d8c;
                            --primary-light: #2a6faf;
                            --primary-dark: #063669;
                            --secondary-color: #e6f2ff;
                            --accent-color: #ff6b35;
                            --text-color: #333333;
                            --khmer-font: "Kantumruy Pro", "Battambang", "Khmer OS", sans-serif;
                            --radius: 8px;
                        }
                        body {
                            font-family: var(--khmer-font);
                            background-color: var(--secondary-color);
                            margin: 0;
                            padding: 0;
                        }
                        .container {
                            max-width: 600px;
                            margin: 40px auto;
                            background: white;
                            border-radius: var(--radius);
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                            padding: 20px;
                            text-align: center;
                        }
                        h2 {
                            color: var(--primary-color);
                            font-size: 1.8rem;
                            margin-bottom: 20px;
                        }
                        p {
                            font-size: 1.1rem;
                            color: var(--text-color);
                        }
                        .btn {
                            display: inline-block;
                            background: var(--accent-color);
                            color: white;
                            padding: 12px 20px;
                            border-radius: var(--radius);
                            text-decoration: none;
                            margin-top: 20px;
                            font-weight: bold;
                        }
                        .btn:hover {
                            background: var(--primary-dark);
                        }
                        .credentials-container {
                            margin-top: 30px;
                            padding: 20px;
                            background-color: var(--primary-light);
                            border-radius: var(--radius);
                            text-align: left;
                        }
                        input {
                            padding: 8px 12px;
                            border: 1px solid var(--primary-dark);
                            border-radius: var(--radius);
                            margin-right: 10px;
                            font-size: 1rem;
                            color: var(--text-color);
                            background-color: #f0f0f0;
                            width: 100%;
                            margin-bottom: 15px;
                        }
                        .change-password-btn {
                            display: inline-block;
                            background: var(--primary-color);
                            color: white;
                            padding: 12px 20px;
                            border-radius: var(--radius);
                            text-decoration: none;
                            margin-top: 15px;
                            font-weight: bold;
                        }

                        footer {
                            margin-top: 40px;
                            padding: 20px;
                            background-color: var(--primary-color);
                            color: white;
                            text-align: center;
                            font-size: 0.9rem;
                            border-radius: var(--radius);
                        }
                    </style>
                </head>
                <body>
                    <main class="container">
                        <div class="success-message">
                            <h2>✅ ការចុះឈ្មោះរបស់អ្នកបានជោគជ័យ!</h2>
                            <p>សូមអរគុណសម្រាប់ការចុះឈ្មោះ។ យើងនឹងទាក់ទងអ្នកឆាប់ៗនេះ។</p>
                            <a href="../pages/login.html" class="btn">ចូលទៅកាន់គណនីរបស់អ្នក</a>
                            <section>
                                <div id="user-credentials" class="credentials-container">
                                    <label for="email-input">📧 អ៊ីមែល:</label>
                                    <input type="text" id="email-input" value="' . $email . '" readonly />
                                    <label for="password-input">🔑 ពាក្យសម្ងាត់:</label>
                                    <input type="password" id="password-input" value="' . $password . '" readonly />
                                    <p><strong>សូមចំណាំ៖</strong> ពាក្យសម្ងាត់នេះត្រូវបានផ្តល់ដើម្បីចូលប្រើគណនីរបស់អ្នក។ សូមធ្វើការផ្លាស់ប្តូរពាក្យសម្ងាត់នៅពេលក្រោយដើម្បីសុវត្ថិភាព។</p>
                                </div>
                            </section>
                        </div>
                    </main>
                    <footer>
                        © 2025 នាយកដ្ឋានបច្ចេកវិទ្យាព័ត៌មាននៃសាកលវិទ្យាល័យភូមិន្ទភ្នំពេញ។ រក្សាសិទ្ធិគ្រប់យ៉ាង។
                    </footer>
                </body>
                </html>
            ';

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
?>
