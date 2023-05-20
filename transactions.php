<?php

// Include database connection, login check, and navbar
include('LoginCheck.php');
include('db_connection.php');
include('navbar.php');

// Get user ID from session
$userID = $_SESSION['userID'];
$query = "SELECT accountNumber FROM accounts WHERE userID = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$accountNumber = $row['accountNumber'];
$balance = $row['balance'];
$userData=[];

$sql = "SELECT * FROM users INNER JOIN accounts ON users.userID = accounts.userID WHERE users.userID = $userID";
$res=$db->query($sql);
if($res->num_rows>0){
	$userData=$row=$res->fetch_assoc();
}

//Creates a usable token
function getToken(){
  $token = sha1(mt_rand());
  if(!isset($_SESSION['tokens'])){
    $_SESSION['tokens'] = array($token => 1);
  }
  else{
    $_SESSION['tokens'][$token] = 1;
  }
  return $token;
}

// Check token's validity and remove it from valid token list
function isTokenValid($token){
  if(!empty($_SESSION['tokens'][$token])){
    unset($_SESSION['tokens'][$token]);
    return true;
  }
  return false;
}

// Instantiate one token to use for the form
$token = getToken();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Transaction Form</title>
	<!-- Bootstrap CDN -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!-- jQuery CDN -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Bootstrap JS CDN -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- style for the blinking -->
	<style>
      .error-message {
        font-weight: bold;
        background-color: #ffcccc;
        padding: 10px;
        animation: blink 1s linear 0s 3;
      }
      .success-message {
        font-weight: bold;
        background-color: #80ff80;
        padding: 10px;
        animation: blink 0.5s 3;
        }
        
        .text-muted {
        position: fixed;
        top: 56;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
    }

      @keyframes blink {
        0% {
          opacity: 1;
        }
        50% {
          opacity: 0;
        }
        100% {
          opacity: 1;
        }
      }
      
    body {
        background-image: url('images/blue.jpg');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        /* Adjust the background-size property to zoom out */
        background-size: 100%;
         }
</style>
    
<script>
      // Get the error message element
      var errorMessage = document.querySelector('.error-message');
    
      // If the element exists, add the 'blink' class to it
      if (errorMessage) {
        errorMessage.classList.add('blink');
      }
</script>
</head>
<body>

<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<h4>Transaction Form</h4>
				</div>
				<div class="card-body">
					<form method="post">
					    <input type="hidden" name="token" value="<?php echo $token;?>"/>
						<div class="form-group">
						    <p class="font-weight-bold">Balance: $<?php echo $userData["balance"]; ?></p>
							<label for="accountNumber">Account Number:</label>
							<input type="text" class="form-control" name="accountNumber" value="<?php echo $accountNumber; ?>" readonly>
						</div>
						<div class="form-group">
							<label for="transactionType">Transaction Type:</label>
							<select class="form-control" name="transactionType" required>
							    <option value="" disabled selected>Select transaction type</option>
							    <option value="Deposit">Deposit</option>
							    <option value="Withdrawal">Withdrawal</option>
							</select>
						</div>
						<div class="form-group">
							<label for="amount">Amount:</label>
							<input type="number" step="0.01" class="form-control" name="amount" placeholder="$" required>
						</div>
						<button type="submit" name="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>

<?php
// Check if a form has been sent
$postedToken = filter_input(INPUT_POST, 'token');
if(!empty($postedToken)){
  if(isTokenValid($postedToken)){
    // Get form data
	//$accountNumber = $_POST['accountNumber'];
	$transactionType = $_POST['transactionType'];
	$amount = $_POST['amount'];

	// Check if account belongs to user
	$query = "SELECT * FROM accounts WHERE userID = $userID AND accountNumber = $accountNumber";
	$result = mysqli_query($db, $query);
	if (mysqli_num_rows($result) == 1) {
		// Get current balance
		$row = mysqli_fetch_assoc($result);
		$balance = $row['balance'];


        if ($amount < 0.01) {
            // Display error message if amount is less than 0.01
            echo "<p class='text-muted mb-4 text-center error-message'>Error: Negative Amount is not accepted.</p>";
            exit;
    }

		// Update balance based on transaction type and amount
		// Update balance based on transaction type and amount
        if ($transactionType == 'Deposit') {
            $balance += $amount;
        } else if ($transactionType == 'Withdrawal') {
            if ($amount > $balance) {
                // Display error message if amount is greater than balance
                echo "<p class='text-muted mb-4 text-center error-message'>Error: Insufficient funds.</p>";
                    exit;
            } else {
                $balance -= $amount;
            }
        }


		// Update account balance
		$query = "UPDATE accounts SET balance = $balance WHERE userID = $userID AND accountNumber = $accountNumber";
		mysqli_query($db, $query);

		// Insert transaction into database
		$query = "INSERT INTO transactions (accountNumber, transactionType, amount) VALUES ($accountNumber, '$transactionType', $amount)";
		mysqli_query($db, $query);

        	// Display success message
	    echo "<p class='text-muted mb-4 text-center success-message'>Transaction completed successfully.</p>";

    } else {
    	// Display error message if account does not belong to user
    	echo "<p class='text-muted mb-4 text-center'>Error: Account not found.</p>";
    }
  }
}


?>
