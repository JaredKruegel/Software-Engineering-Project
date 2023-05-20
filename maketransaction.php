<?php
// Initialize variables from the form ?? initalizes the variables for future problems
$transferFrom = $_POST['transferFrom'] ?? '';
$transferTo = $_POST['transferTo'] ?? '';
$amount = $_POST['amount'] ?? '';

// In order to connect to database and checks log in stat
require_once 'db_connection.php';
require_once 'LoginCheck.php';

//assures that the following will run if the SUBMIT button is pressed on
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //taking the balance number -> from accountnum to transferFrom 
    $sql = "SELECT balance FROM accounts WHERE accountNumber = '$transferFrom'";
    $result = $db->query($sql);
    $row = mysqli_fetch_assoc($result);
    //assuring amount asked to balance isn't greater than the balance
    if ($amount > $row['balance']) {
        //doesn't complete transfer sends message to the top
        echo "Insufficient funds.";
        //// if numbers are valid complete transfer
    } else {
        // subtracts the amount from the transferFrom(requester)
        $sql = "UPDATE accounts SET balance = balance - $amount WHERE accountNumber = '$transferFrom'";
        $db->query($sql);
        //transferTo account adds the balance requested to transfer
        $sql = "UPDATE accounts SET balance = balance + $amount WHERE accountNumber = '$transferTo'";
        $db->query($sql);
        //wooo we did it shows where the accounts are happening
        echo "Transfer successful! $amount has been transferred from $transferFrom to $transferTo.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Transfer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .card-text {
            height: 100px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class='container mt-5 pb-5'>
        <h2>Transfer</h2>
        <form method="POST" action="maketransaction.php">
            <label for="transferFrom">Transfer From:</label>
            <select id="transferFrom" name="transferFrom">
                <option value="4567">4567</option>
                <option value="account2">Account 2</option>
                <option value="account3">Account 3</option>
            </select>
            <br><br>
            <label for="transferTo">Transfer To:</label>
            <select id="transferTo" name="transferTo">
                <option value="12345">12345</option>
                <option value="account5">Account 5</option>
                <option value="account6">Account 6</option>
            </select>
            <br><br>
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" value="0">
            <br><br>
            <input type="submit" value="SUBMIT">
        </form>
    </div>
</body>
</html>
