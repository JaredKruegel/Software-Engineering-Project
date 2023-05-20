<?php
    include('LoginCheck.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Basic Bank Admin Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            text-align: center;
            background-color: #f2f2f2;
        }
        .header {
            background-color: #17a2b8;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
        }
        .navbar {
            background-color: #fff;
            border: none;
            margin: 0;
            padding: 10px;
            justify-content: center;
        }
        .navbar-nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 0;
        }
        .nav-link {
            color: #333;
            font-size: 16px;
            font-weight: bold;
            margin: 0 20px;
            padding: 10px;
            text-decoration: none;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            background-color: #17a2b8;
            color: #fff;
            border-radius: 5px;
        }
        footer {
           position: fixed;
           left: 0;
           bottom: 0;
           width: 100%;
           text-align: center;
        }
        .hover-image {
          transition: all 0.3s ease;
        }
        
        .hover-image:hover {
          transform: scale(1.1);
          box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>
    <nav class="navbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="manage_bankaccount.php">View Bank Accounts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_announcements.php">Manage Announcements</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_transactions.php">Manage Transactions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_users.php">Manage User Subscriptions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </nav>
</body>
    <br><br><img src="images/laptop2.jpg" width="350" height="300" class="hover-image"> 
    <img src="images/money4.jpg" width="350" height="300" class="hover-image">
    <img src="images/laptop4.jpg" width="350" height="300" class="hover-image">
    <img src="images/money.jpg" width="350" height="300" class="hover-image">
    
        <footer>
        <p></p><a href="mailto:admin@bank.com">&copy; Basic Bank 2023</a></p>
    </footer>    <footer>
        <p>
</html>
