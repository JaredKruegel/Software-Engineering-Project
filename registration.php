<?php
// Include config file
require_once "db_connection.php";
 
// Define variables and initialize with empty values
$firstName = $lastName = $email = $password = $confirm_password = "";
$firstName_err = $lastName_err = $useremail_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate first name
    if(empty(trim($_POST["firstName"]))){
        $firstName_err = "Please enter your First Name.";
    } else{
        $firstName = trim($_POST["firstName"]);
    }

    // Validate last name
    if(empty(trim($_POST["lastName"]))){
        $lastName_err = "Please enter your Last Name.";
    } else{
        $lastName = trim($_POST["lastName"]);
    }
 
    // Validate username
    if(empty(trim($_POST["email"]))){
        $useremail_err = "Please enter a User Email.";
    } elseif(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", trim($_POST["email"]))){
        $useremail_err = "Email can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT userID FROM users WHERE email = ?";
        
        if($stmt = $db->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_useremail);
            
            // Set parameters
            $param_useremail = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $useremail_err = "Email is already registered - go back and try another email.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($useremail_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)";
         
        if($stmt = $db->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss",$param_firstName, $param_lastName, $param_useremail, $param_password);
            
            // Set parameters
            $param_firstName = $firstName;
            $param_lastName = $lastName;
            $param_useremail = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Get the last inserted user ID
                $userID = $stmt->insert_id;
                
                // Prepare an insert statement for the user's account table
                $sql = "INSERT INTO accounts (userID, balance) VALUES (?, 0)";
                
                if($stmt = $db->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("i", $param_userID);
        
                    // Set parameters
                    $param_userID = $userID;
        
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        header("location: user_login.php");
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    $stmt->close();
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        
            // Close statement
            $stmt->close();
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
    <title>Sign Up</title>
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
        <h1>Registration</h1>
        <p>Please fill out this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="firstName" class="form-control <?php echo (!empty($firstName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstName; ?>">
                <span class="invalid-feedback"><?php echo $firstName_err; ?></span>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lastName" class="form-control <?php echo (!empty($lastName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastName; ?>">
                <span class="invalid-feedback"><?php echo $lastName_err; ?></span>
            </div>
            <div class="form-group">
                <label>User Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($useremail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $useremail_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-success" value="Clear">
            </div>
            <p>Already have an account? <a href="user_login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html> 
