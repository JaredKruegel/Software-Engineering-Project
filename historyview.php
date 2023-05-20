<html>
<head>
  <title>Your Transaction History</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>

<style>
.center { /* puts image in Center of page*/
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}

img { /* add border to image */
  border: 5px solid #555;
}

</style>

<body class = "bg-light">
<?php include "navbar.php";?>

<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
          <h1>Past Transactions</h1>
        </div>

				<div class="card-body">

          <form action="results.php" method="post">

						<div class="form-group">
              <label for="searchtype">I am looking for:</label>
              <select class="form-control" name="searchtype" required>
                <option value="" disabled selected>Select History Option</option>
                <option value="Deposit">Recent Deposits
                <option value="Withdraw">Recent Withdraws
                <option value="all">All Account Transactions
              </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Search</button>
          </form>
        </div>
      </div>
		</div>
	</div>

  <div class="container mt-5">
    <img src="images/money2.jpg" style="width:35%" class="center">
  </div>


</div>

</body>
<?php include('LoginCheck.php'); ?>
</html>
