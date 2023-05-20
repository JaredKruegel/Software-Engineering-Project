<?php
//uses mysqli
// include session
include 'LoginCheck.php';

// include the database connection
include 'db_connection.php';

// check if the user submitted the form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // get the form data
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // check if the email is already taken
  $sql = "SELECT * FROM users WHERE email = ?";
  $stmt = mysqli_prepare($db, $sql);
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);

  if ($user) {
    // email already exists in the database, show error message
    $_SESSION['email_error'] = 'This email is already taken. Please use a different email address.';
    header('Location: add_user.php');
    exit;
    }

  // hash the password using the default algorithm
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // insert the user into the users table
  $sql = "INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_prepare($db, $sql);
  mysqli_stmt_bind_param($stmt, "ssss", $firstName, $lastName, $email, $hashedPassword);
  mysqli_stmt_execute($stmt);

  // get the userID of the new user
  $userID = mysqli_insert_id($db);

  // insert the account into the accounts table
  $sql = "INSERT INTO accounts (userID, balance) VALUES (?, 0)";
  $stmt = mysqli_prepare($db, $sql);
  mysqli_stmt_bind_param($stmt, "i", $userID);
  mysqli_stmt_execute($stmt);

  // redirect to the list of users
  header('Location: add_user.php?success=true');
  exit;
}

// check if the user was added successfully, if so display success pop-up
if (isset($_GET['success']) && $_GET['success'] === 'true') {
  echo '<script>alert("User and an associated bank account was successfully added!");</script>';
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add New User</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Font Awesome CSS for eye icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>
<?php
include 'admin_navbar.php';
?>
  <div class="container">
    <h1 class="my-4">Add User</h1>
    <?php
    // show an error message
    if (isset($_SESSION['email_error'])) {
      echo '<div class="alert alert-danger">' . $_SESSION['email_error'] . '</div>';
      unset($_SESSION['email_error']);
    }
    ?>
    <form method="post">
      <div class="form-group">
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" id="firstName" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" id="lastName" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" class="form-control" required>
        </div>
       <div class="form-group">
            <label for="password">Password:</label>
        <div class="input-group">
            <input type="password" name="password" id="password" class="form-control" required>
            <div class="input-group-append">
              <button type="button" class="btn btn-outline-secondary" id="toggle-password">
                <i class="fa fa-eye" aria-hidden="true"></i>
              </button>
            </div>
         </div>
        </div>
      <button type="submit" class="btn btn-success">Add User</button>
      <a href="manage_users.php" class="btn btn-primary">Back to Manage Users</a>
    </form>
    </div>

    <script>
    /* toggle visibility of password with event listener */
      $(document).ready(function() {
        $("#toggle-password").click(function() {
          var passwordField = $("#password");
          var passwordFieldType = passwordField.attr("type");
          if (passwordFieldType === "password") {
            passwordField.attr("type", "text");
            // change the icon to an eye with a slash through it
            $(this).html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
          } else {
            passwordField.attr("type", "password");
            // change the icon back to a normal eye
            $(this).html('<i class="fa fa-eye" aria-hidden="true"></i>');
          }
        });
      });
    </script>
</body>
</html>
