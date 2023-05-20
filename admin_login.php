<?php
    include('LoginCheck.php');
    include('db_connection.php');
 
// Define variables and initialize with empty values
$Email = $Password = "";
$email_error = $password_error = $login_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["Email"]))){
        $email_error = "Please enter email address.";
    } else{
        $Email = trim($_POST["Email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["Password"]))){
        $password_error = "Please enter password.";
    } else{
        $Password = trim($_POST["Password"]);
    }
    
    // Validate username and password
    if(empty($email_error) && empty($password_error)){
        // Prepare a select statement
        $query = "SELECT `adminID`,`email`,`password` FROM `admin` WHERE email = ?";
        
        if($result = $db->prepare($query)){
            // Set parameters
            $param_email = $Email;
            
            // Bind variables to the prepared statement as parameters
            $result->bind_param("s", $param_email);
            
            // Attempt to execute the prepared statement
            if($result->execute()){
                // Store result
                $result->store_result();
                
                // Check if username exists, if yes then verify password
                if($result->num_rows == 1){                    
                    // Bind result variables and hash password for security
                    $result->bind_result($adminID, $Email, $hashed_password);
                    if($result->fetch()){
                        if(password_verify($Password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["adminID"] = $adminID;
                            $_SESSION["Email"] = $Email;
                            
                            // Redirect user to welcome page
                            header("location: admin_homepage.php");
                                
                        } else{
                            // Password is not valid, display a generic error message
                            $login_error = "Invalid password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_error = "Invalid username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $result->close();
        }
    }
    
    // Close connection
    $db->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { 
            font: 14px sans-serif; }
        .container { 
            width: 900px; padding: 10px;
        }
        #footer {
            position:fixed;
            bottom:10px;
            left: 50%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bank Admin Login</h2>
        <p>Please enter you're account information to login</p>

        <?php 
        if(!empty($login_error)){
            echo '<div class="alert alert-danger">' . $login_error . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group row">
                <label class = "col-form-label col-sm-2">Email Address</label>
               <div class = "col-sm-10"> <input type="text" name="Email" class="form-control <?php echo (!empty($email_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $Email; ?>">
                <span class="invalid-feedback"><?php echo $email_error; ?></span></div>
            </div>    
            <div class="form-group row">
                <label class = "col-form-label col-sm-2 ">Password</label>
                <div class = "col-sm-10"><input type="password" name="Password" class="form-control <?php echo (!empty($password_error)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_error; ?></span></div>
            </div>
            <div class="form-group">
                <div class= "offset-sm-2 col-sm-10">
                    <input type="submit" class="btn btn-primary" value="Login">
                    <input type="reset" class="btn btn-success" value="Clear">
                </div>
            </div>
        </form>
        <div class= "offset-sm-2 col-sm-10">
            <form action="user_login.php">
                <input type="submit" class="btn btn-dark" value="Customer Login" />
            </form>
        </div>
    </div>
    <footer id ="footer"><a href = "mailto: bank@gmail.com">&copy; 2022 Bank</a></footer>
</body>
</html>