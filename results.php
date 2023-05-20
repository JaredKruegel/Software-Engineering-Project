<?php
    include 'LoginCheck.php';
    include 'db_connection.php';
    
    // Get the account number based on the user's ID stored in the session
    $userID = $_SESSION['userID'];
    $query = "SELECT accountNumber FROM accounts WHERE userID = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $accountNumber = $row['accountNumber'];
    
    // Get the transaction history based on the user's selection
    $searchType = $_POST['searchtype'];
    if ($searchType == 'Deposit') {
        $query = "SELECT * FROM transactions WHERE accountNumber = ? AND transactionType = 'Deposit'";
    } elseif ($searchType == 'Withdraw') {
        $query = "SELECT * FROM transactions WHERE accountNumber = ? AND transactionType = 'Withdrawal'";
    } else {
        $query = "SELECT * FROM transactions WHERE accountNumber = ?";
    }
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $accountNumber);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
?>

<html>
    <head>
        <title>Your Transaction History</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    </head>
    <body class = "bg-light">
        <?php
            include "navbar.php";
        ?>
        <div class="container">
            <h1 class="my-4">Past Transactions</h1>
            <?php if (mysqli_num_rows($result) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Transaction ID</th>
                                <th>Account Number</th>
                                <th>Transaction Type</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody class = "bg-white">
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['transactionID']; ?></td>
                                    <td><?php echo $row['accountNumber']; ?></td>
                                    <td><?php echo $row['transactionType']; ?></td>
                                    <td>$<?php echo $row['amount']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <a href="historyview.php" class="btn btn-primary mt-3">Back to Transactions View</a>
                </div>
            <?php } else { ?>
                <p>No transactions found for the selected search type.</p>
            <?php } ?>
        </div>
        <?php mysqli_close($db); ?>
    </body>
</html>
