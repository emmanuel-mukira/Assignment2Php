<?php
session_start();
require_once "includes/constants.php"; // Load database constants

if (isset($_POST['submit'])) {
    $userCode = trim($_POST['verification_code']);
    if (!isset($_SESSION['email'])) {
        die("No email found in session. Please log in or sign up again.");
    }

    $email = $_SESSION['email']; // Retrieve the email from session

    // Connect to the database using constants
    $db = new mysqli(HOSTNAME, HOSTUSER, HOSTPASS, DBNAME);

    if ($db->connect_error) {
        die("Database connection failed: " . $db->connect_error);
    }

    // Fetch the stored verification code and expiry for the user
    $stmt = $db->prepare("SELECT verification_code, ver_code_expiry FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($storedCode, $verCodeExpiry);
    $stmt->fetch();
    $stmt->close();

    if (!$storedCode) {
        die("No verification code found for this user.");
    }

    if ($storedCode === $userCode) {
        // Check if the code is expired
        $currentDateTime = new DateTime();
        $expiryDateTime = new DateTime($verCodeExpiry);

        if ($currentDateTime <= $expiryDateTime) {
            // Update the user's account as verified
            $stmt = $db->prepare("UPDATE users SET is_verified = 1 WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->close();

            echo "Successfully Verified!";
        } else {
            echo "The verification code has expired. Please request a new code.";
        }
    } else {
        echo "Invalid Verification Code.";
    }

    $db->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account</title>
</head>
<body>
    <h1>Account Verification</h1>
    <form action="verify.php" method="POST">
        <label for="verification_code">Enter Verification Code:</label>
        <input type="text" id="verification_code" name="verification_code" required>
        <button type="submit" name="submit">Verify</button>
    </form>
</body>
</html>
