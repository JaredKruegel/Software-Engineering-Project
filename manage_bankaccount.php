<?php
//uses PDO
include('db_connection.php');
include('LoginCheck.php');
// include the admin navbar
include 'admin_navbar.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Customer Account Information</title>
	<!-- Add Bootstrap links -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
	<h1 class="text-center my-5">Account Information</h1>
	<div class="container">
		<table class="table table-hover">
			<thead class="thead-light">
				<tr>
					<th>User ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Account Number</th>
					<th>Balance</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = "SELECT users.userID, users.firstName, users.lastName, users.email, accounts.accountNumber, accounts.balance FROM users INNER JOIN accounts ON users.userID = accounts.userID";
				$result = $db->query($sql);

				if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
				        echo "<tr>";
				        echo "<td>" . $row['userID'] . "</td>";
				        echo "<td>" . $row['firstName'] . "</td>";
				        echo "<td>" . $row['lastName'] . "</td>";
				        echo "<td>" . $row['email'] . "</td>";
				        echo "<td>" . $row['accountNumber'] . "</td>";
				        echo "<td>$" . $row['balance'] . "</td>";
				        echo "</tr>";
				    }
				} else {
				    echo "<tr><td colspan='6'>No accounts found</td></tr>";
				}

				$db->close();
				?>
			</tbody>
		</table>

		<a href="admin_homepage.php" class="btn btn-success mt-3">Back to Dashboard</a>
	</div>

	<footer class = "text-center">
        <p><a href="mailto:admin@bank.com">&copy; Basic Bank 2023</a></p>
    </footer>
</body>
</html>
