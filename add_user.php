<?php
require 'includes/db_connection.php'; // Ensure you include the database connection file.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $genderId = $_POST['genderId'];
    $roleId = $_POST['roleId'];

    // Database query to insert user details
    $sql = "INSERT INTO users (fullname, email, password, gender_id, role_id) VALUES (:fullname, :email, :password, :gender_id, :role_id)";
    
    // Prepare and execute the query
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':fullname' => $fullname,
        ':email' => $email,
        ':password' => $password,
        ':gender_id' => $genderId,
        ':role_id' => $roleId
    ]);

    if ($stmt) {
        echo "User registered successfully!";
    } else {
        echo "Error: Could not register user.";
    }
}
?>
