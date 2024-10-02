<?php

// Include the required files for database connection and constants
require_once dirname(__DIR__) . "/includes/constants.php";
require_once dirname(__DIR__) . "/includes/dbConnection.php";

class auth {
    private $conn;

    public function __construct() {
        $this->conn = new dbConnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);
    }

    public function signup() {
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

            // Validate email
            if (!$email_address) {
                $errors[] = "Invalid email format.";
            }

            // Validate email domain
            $allowed_domains = ['strathmore.edu', 'gmail.com'];
            $email_domain = substr(strrchr($email_address, "@"), 1);
            if (!in_array($email_domain, $allowed_domains)) {
                $errors[] = "Email domain not authorized.";
            }

            // Check for existing email
            $stmt = $this->conn->getConnection()->prepare("SELECT email FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email_address);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $errors[] = "Email address already exists.";
            }

            // Check for existing username
            $stmt = $this->conn->getConnection()->prepare("SELECT username FROM users WHERE username = :username");
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
                foreach ($errors as $error) {
                    echo "<p>$error</p>";
                }
                return;
            }

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into the database
            $data = [
                'fullname' => $fullname,
                'email' => $email_address,
                'username' => $username,
                'password' => $hashed_password,
                'genderId' => $genderId,
                'roleId' => $roleId
            ];

            // Use the insert method to add data to the database
            if ($this->conn->insert('users', $data)) {
                echo "Added successfully";
                exit();
            } else {
                die("Error: Failed to add user");
            }
        }
    }
}
