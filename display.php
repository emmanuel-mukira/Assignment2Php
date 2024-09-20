<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Users List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Gender</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require 'includes/dbConnection.php';
                require 'user.php';

                // Create a new database connection object
                $db = new dbConnection('PDO', 'localhost', 'root', '', 'your_db_name', null);
                $conn = $db->getConnection();

                // Instantiate the User class
                $user = new User($conn);

                // Fetch all users
                $users = $user->getAllUsers();

                // Loop through and display each user
                foreach ($users as $user) {
                    echo "<tr>
                            <td>{$user['userId']}</td>
                            <td>{$user['fullname']}</td>
                            <td>{$user['email']}</td>
                            <td>{$user['username']}</td>
                            <td>{$user['genderId']}</td>
                            <td>{$user['roleId']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>