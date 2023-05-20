<?php 
include('db_connection.php');
include('LoginCheck.php');

$userData=[];

$userID = $_SESSION["userID"];
$sql = "SELECT * FROM users INNER JOIN accounts ON users.userID = accounts.userID WHERE users.userID = $userID";

$res=$db->query($sql);

if($res->num_rows>0){
    $userData=$row=$res->fetch_assoc();
}
?>

<html>
    <head>
        <title>Account Details</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    </head>
    <body class="bg-light">
        <?php include "navbar.php"; ?>
        <div class='container mt-5'>
            <div class='row'>
                <div class='col-md-9 mx-auto'>
                    <h2 class='mb-4'>Account Details</h2><hr>
                    <div class="card">
                        <div class="card-body">
                            <h3 class=" text-muted mb-4">User</h3>
                            <p class="font-weight-bold">User ID: <?php echo $userData["userID"]; ?></p>
                            <p class="font-weight-bold">First Name:  <?php echo $userData["firstName"]; ?></p>
                            <p class="font-weight-bold">Last Name: <?php echo $userData["lastName"]; ?></p>
                            <p class="font-weight-bold">Email: <?php echo $userData["email"]; ?></p>
                            <hr>
                            <h3 class="text-muted mb-4">Account</h3>
                            <p class="font-weight-bold">Account Number: <?php echo $userData["accountNumber"]; ?></p>
                            <p class="font-weight-bold">Balance: $<?php echo $userData["balance"]; ?></p>
                            <?php if($userData["balance"] < 100): ?>
                                <div class="alert alert-danger text-center" role="alert">
                                    Your account balance is below $100. Please add funds.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
