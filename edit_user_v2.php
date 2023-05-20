<?php
include('db_connection.php');
include('LoginCheck.php');
// include the admin navbar
include 'admin_navbar.php';

if (isset($_POST['save_changes'])) {
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    
    // Update user details in database - prevents SQL injections using bind_param
    $stmt = $db->prepare("UPDATE users SET firstName=?, lastName=?, email=? WHERE userID=?");
    $stmt->bind_param("sssi", $first_name, $last_name, $email, $user_id);
    if ($stmt->execute()) {
        echo "<script>alert('User information updated successfully.')</script>";
    } else {
        echo "<script>alert('Error updating user information.')</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bank Customers</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Bank Customer List</h1>
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
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['userID'] . "</td>";
                        echo "<td>" . $row['firstName'] . "</td>";
                        echo "<td>" . $row['lastName'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>";
                        echo "<button type='button' class='btn btn-success' data-toggle='modal' data-target='#editModal" . $row['userID'] . "'>Edit</button>";
                        echo "</td>";
                        echo "</tr>";
                        
                        // Edit user modal
                        echo "<div class='modal fade' id='editModal" . $row['userID'] . "' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>";
                        echo "<div class='modal-dialog' role='document'>";
                        echo "<div class='modal-content'>";
                        echo "<div class='modal-header'>";
                        echo "<h5 class='modal-title' id='editModalLabel'>Edit User Details</h5>";
                        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                        echo "<span aria-hidden='true'>&times;</span>";
                        echo "</button>";
                        echo "</div>";
                        echo "<form method='POST'>";
                        echo "<div class='modal-body'>";
                        echo "<div class='form-group'>";
                        echo "<label for='first_name'>First Name</label>";
                        echo "<input type='text' class='form-control' id='first_name' name='first_name' value='" . $row['firstName'] . "'>";
                        echo "</div>";
                        echo "<div class='form-group'>";
                        echo "<label for='last_name'>Last Name</label>";
                        echo "<input type='text' class='form-control' id='last_name' name='last_name' value='" . $row['lastName'] . "'>";
                        echo "</div>";
                        echo "<div class='form-group'>";
                        echo "<label for='email'>Email</label>";
                        echo "<input type='email' class='form-control' id='email' name='email' value='" . $row['email'] . "'>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='modal-footer'>";
                        echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
                        echo "<button type='submit' class='btn btn-primary' name='save_changes'>Save changes</button>";
                        echo "<input type='hidden' name='user_id' value='" . $row['userID'] . "'>";
                        echo "</div>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                }
                } else {
                echo "<tr><td colspan='5' class='text-center'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="admin_homepage.php" class="btn btn-primary">Back to Dashboard</a>
        <a href="manage_users.php" class="btn btn-secondary">Back to Manage Users</a>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
