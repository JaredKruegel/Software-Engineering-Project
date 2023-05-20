<?php
// uses mysqli
include('db_connection.php');
include('LoginCheck.php');
// include the admin navbar
include 'admin_navbar.php';

// Handle search query
if (isset($_GET['search'])) {
    // prevent SQL injections
    $search = mysqli_real_escape_string($db, $_GET['search']);
    $sql = "SELECT userID, firstName, lastName, email FROM users WHERE firstName LIKE '%$search%' OR lastName LIKE '%$search%' OR userID LIKE '%$search%' OR email LIKE '%$search%'";
} else {
    $sql = "SELECT userID, firstName, lastName, email FROM users";
}

if (isset($_POST['delete_user'])) {
    // prevent SQL injections
    $user_id = mysqli_real_escape_string($db, $_POST['delete_user']);

    // Delete user's account from the database
    $sql = "DELETE FROM accounts WHERE userID = '$user_id'";
    if ($db->query($sql) === TRUE) {
        // Delete user from the database
        $sql = "DELETE FROM users WHERE userID = '$user_id'";
        if ($db->query($sql) === TRUE) {
            // Success message
            echo "<script>alert('User deleted successfully');</script>";
        } else {
            // Error message
            echo "<script>alert('Error deleting user');</script>";
        }
    } else {
        // Error message
        echo "<script>alert('Error deleting user');</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Bank Customers</title>
    <!-- Link Bootstrap CSS file -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Bank Customer List</h1>

        <!-- Search form -->
        <br><div class="d-flex justify-content-center mt-3 mb-4">
            <form class="form-inline">
                <div class="form-group">
                    <label for="search" class="sr-only">Search:</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search">
                </div>
                <button type="button" class="btn btn-link"><i class="fa fa-search"></i></button>
            </form>
        </div>
        
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT userID, firstName, lastName, email FROM users";
                if(isset($_GET['search']) && !empty($_GET['search'])){
                    $search = mysqli_real_escape_string($db, $_GET['search']);
                    $sql .= " WHERE userID LIKE '%$search%' OR firstName LIKE '%$search%' OR lastName LIKE '%$search%' OR email LIKE '%$search%'";
                }

                $result = $db->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['userID'] . "</td>";
                        echo "<td>" . $row['firstName'] . "</td>";
                        echo "<td>" . $row['lastName'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td><form method='post'><button type='submit' name='delete_user' value='" . $row['userID'] . "' class='btn btn-danger'>Delete</button></form></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="admin_homepage.php" class="btn btn-primary">Back to Dashbooard</a>
        <a href="edit_user_v2.php" class="btn btn-secondary">Edit User</a>
        <a href="add_user.php" class="btn btn-success">Add User</a>
    </div><br><br>

    <!-- Link Bootstrap JS file -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
