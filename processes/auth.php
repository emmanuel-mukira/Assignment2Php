<?php

require_once dirname(__DIR__) . "/includes/constants.php";
require_once dirname(__DIR__) . "/includes/dbConnection.php";

class auth {
    private $mail;

    public function __construct() {
        // Initialize the SendMail object directly in the constructor
        $this->mail = new SendMail();
        
    }
    public function signup($conn,$lang) {
        // Define the protocol and base URL
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';

        // Initialize the $conf array
        $conf = [];
        $conf['ver_code_time'] = date("Y-m-d H:i:s", strtotime("+ 1 days"));
        $conf['verification_code'] = rand(10000, 99999);
        $conf['site_initials'] = "ICS 2024";
        $conf['site_url'] = "$base_url/" . DBNAME;
        $conf['valid_domains'] = ["strathmore.edu", "gmail.com", "yahoo.com", "mada.co.ke", "outlook.com"];

        if (isset($_POST["signup"])) {
            // Sanitize and retrieve form data
            $fullname = trim($_POST["fullname"]);
            $email_address = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);
            $genderId = trim($_POST["genderId"]);
            $roleId = trim($_POST["roleId"]);

            // Implement input validation and error handling
            $errors = [];

            // Validate email format
            if (!$email_address) {
                $errors[] = "Invalid email format.";
            }

            // Validate email domain
            $email_domain = substr(strrchr($email_address, "@"), 1);
            if (!in_array($email_domain, $conf['valid_domains'])) {
                $errors[] = "Email domain not authorized.";
            }

            // Check for existing email
            $stmt = $conn->prepare("SELECT email FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email_address);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $errors[] = "Email address already exists.";
            }

            // Check for existing username
            $stmt = $conn->prepare("SELECT username FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $errors[] = "Username already exists.";
            }

            // Validate password length
            if (strlen($password) < 4 || strlen($password) > 8) {
                $errors[] = "Password must be between 4 and 8 characters.";
            }

            // Display validation errors if any
            if (!empty($errors)) {
                session_start();
                $_SESSION['errors'] = $errors; // Store errors in session
                header("Location: signup.php"); // Redirect back to signup page
                exit;
            }

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user data into the database along with verification details
            $sql = "INSERT INTO users (fullname, email, username, password, roleId, genderId, verification_code, ver_code_expiry)
                    VALUES (:fullname, :email, :username, :password, :roleId, :genderId, :verification_code, :ver_code_expiry)";
            
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([
                ':fullname' => $fullname,
                ':email' => $email_address,
                ':username' => $username,
                ':password' => $hashed_password,
                ':roleId' => $roleId,
                ':genderId' => $genderId,
                ':verification_code' => $conf['verification_code'],
                ':ver_code_expiry' => $conf['ver_code_time']
            ])) {
                // Prepare the email message
                $mailMsg = [
                    'to_email' => $email_address,
                    'to_name'  => $fullname,
                    'subject'  => $lang['AccountVerification'],
                    'message'  => str_replace(
                        ['{{fullname}}', '{{verification_code}}', '{{site_full_name}}'],
                        [$fullname, $conf['verification_code'], $conf['site_initials']],
                        $lang['AccRegVer_template']
                    )
                ];
            
                // Call the SendMail method to send the email
                try {
                    $this->mail->SendMail($mailMsg); // Use the SendMail object to send the email
                    session_start(); // Ensure the session is started
                    $_SESSION['email'] = $email_address; // Store email in session
                    echo 'Sign up successful. Please check your email for the verification code.';
                } catch (Exception $e) {
                    // Handle error, possibly log it
                    echo 'Email could not be sent: ' . $e->getMessage();
                }
            } else {
                die("Error: Failed to add user");
            }
        }
    }
}
