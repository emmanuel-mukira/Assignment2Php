<?php
//error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "includes/constants.php";
require_once "includes/dbConnection.php";

// Create a database connection
$conn = new dbConnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);

// Check if the form is submitted
if (isset($_POST['signup'])) {
    // Capture form data
    $fullname = $_POST['fullname'];
    $email_address = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $genderId = $_POST['genderId']; // Get gender from the form
    $roleId = $_POST['roleId'];     // Get role from the form

    // Prepare the data for insertion
    $data = [
        'fullname' => $fullname,
        'email' => $email_address,
        'username' => $username,
        'password' => $password,
        'genderId' => $genderId,
        'roleId' => $roleId
    ];

    // Insert the data into the database
    $insert = $conn->insert('users', $data);

    if ($insert === TRUE) {
        // Redirect on success
        echo "User created successfully!";
        exit();
    } else {
        // Handle insert error
        echo "Error: " . $insert;
    }
}
?>
