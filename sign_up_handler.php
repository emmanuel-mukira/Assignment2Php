<!-- 
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the authentication class (auth.php will take care of database connection)
require_once "processes/auth.php";

// Instantiate the auth class
$auth = new auth();

// Call the signup method to process the form submission
$auth->signup();
?> -->
