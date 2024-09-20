<?php
class auth {
    public function signup($conn) {
        if (isset($_POST["signup"])) {
            // Sanitize and retrieve form data
            $fullname = $conn->real_escape_string(trim($_POST["fullname"]));
            $email_address = filter_var(trim($_POST["email_address"]), FILTER_VALIDATE_EMAIL);
            $username = $conn->real_escape_string(trim($_POST["username"]));
            $password = trim($_POST["password"]);
            $repeat_password = trim($_POST["repeat_password"]);

            // Implement input validation and error handling
            $errors = [];

            // 1. Verify that the email has the correct format
            if (!$email_address) {
                $errors[] = "Invalid email format.";
            }

            // 2. Verify that the email address domain is authorized
            $allowed_domains = ['strathmore.edu', 'gmail.com'];
            $email_domain = substr(strrchr($email_address, "@"), 1);
            if (!in_array($email_domain, $allowed_domains)) {
                $errors[] = "Email domain not authorized.";
            }

            // 3. Verify that the new email address does not exist already in the database
            $email_check_query = $conn->query("SELECT email FROM users WHERE email = '$email_address'");
            if ($email_check_query->num_rows > 0) {
                $errors[] = "Email address already exists.";
            }

            // 4. Verify that the new username does not exist already in the database
            $username_check_query = $conn->query("SELECT username FROM users WHERE username = '$username'");
            if ($username_check_query->num_rows > 0) {
                $errors[] = "Username already exists.";
            }

            // 5. Verify that the password is identical to the repeat password
            if ($password !== $repeat_password) {
                $errors[] = "Passwords do not match.";
            }

            // 6. Verify that the password length is between 4 and 8 characters
            if (strlen($password) < 4 || strlen($password) > 8) {
                $errors[] = "Password must be between 4 and 8 characters.";
            }

            // 7. If there are validation errors, display them
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p>$error</p>";
                }
                return;
            }

            // 8. Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 9. Insert user into the database (assuming genderId and roleId default to 1)
            $cols = ['fullname', 'email', 'username', 'password', 'genderId', 'roleId'];
            $vals = [$fullname, $email_address, $username, $hashed_password, 1, 1];

            $data = array_combine($cols, $vals);
            
            // Prepare insert query
            $sql = "INSERT INTO users (fullname, email, username, password, genderId, roleId) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssii', $data['fullname'], $data['email'], $data['username'], $data['password'], $data['genderId'], $data['roleId']);
            if ($stmt->execute()) {
                // Redirect to signup page on success
                echo "Added successfully";
                exit();
            } else {
                die("Error: " . $conn->error);
            }
        }
    }
}
?>
