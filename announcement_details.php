<?php 
include('db_connection.php');
include('LoginCheck.php');
	
if(isset($_POST["submit"])){
	$announcement = [
		"id" => $_POST["announcementID"],
		"title" => $_POST["title"],
		"desc" => $_POST["description"],
		"date" => $_POST["datePosted"]
	];
}

$data = [];

$sql = "SELECT * FROM announcements WHERE announcementID = {$_GET["id"]}";

$res = $db->query($sql);

if($res->num_rows > 0){
	$data = $res->fetch_assoc();
}
?>
<html>
	<head>
        <title>Your Announcements</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    </head>
    <body class = "bg-light">
		<?php include "navbar.php"; ?>
		<div class='container mt-5'>
			<div class='row'>
				<div class='col-md-9 mx-auto'>
					<h2 class='text-muted mb-4'>Announcement</h2><hr>
					<div class='row mt-5'>
						<div class='col-md-4'>
						</div>	
						<div class='col-md-8'>
							<h2 class='text-muted'><?php echo $data["title"]; ?></h2>
							<p class="font-weight-bold">Posted: <?php echo date("m/d/Y", strtotime($data["datePosted"])); ?></p>
							<p><strong>Description:</strong> <?php echo $data["description"]; ?></p>
							
							<form method='post' action='<?php echo $_SERVER["REQUEST_URI"];?>'>
								<input type='hidden' name='announcementID' value='<?php echo $data["announcementID"]; ?>'>
								<input type='hidden' name='title' value='<?php echo $data["title"]; ?>'>
								<input type='hidden' name='description' value='<?php echo $data["description"]; ?>'>
								<input type='hidden' name='datePosted' value='<?php echo $data["datePosted"]; ?>'>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
    </body>
</html>
