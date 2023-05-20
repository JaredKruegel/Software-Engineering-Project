<?php 
include('db_connection.php');
include('LoginCheck.php'); 
  
	$data=[];
	
	$sql="select * from announcements";
	
	$res=$db->query($sql);
	
	if($res->num_rows>0){
	    
		while($row=$res->fetch_assoc()){
		    
			$data[]=$row;
		}
	}
?>
<html>
	<head>
        <title>Your Announcements</title>
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
			<h2 class='text-muted mb-4 text-center'>Announcement Dashboard</h2>
			<div class='row'>
				
            <?php
                if($res->num_rows == 0){
                   echo "<html><p class='text-muted mb-4 text-center'>No New Announcements Right Now!</p></html>";
               }
            ?>

            <?php foreach($data as $row): ?>
					<div class='col-md-3 mt-2'>
						<div class="card">
						  <!--<img class="card-img-top" src="images/<?php echo $row["image"]; ?>" > Can make basic bank image default-->
						  <div class="card-body">
							<h5 class="card-title"><?php echo $row["title"]; ?></h5>
							<p class="card-text">
							<strong>Posted: </strong><?php echo date('m/d/Y', strtotime($row["datePosted"])); ?><br>	
                            				<?php echo $row["description"]; ?>
							</p>
							<a href="announcement_details.php?id=<?php echo $row["announcementID"]; ?>" class='btn btn-primary  float-right' >Open Announcement</a>
						  </div>
						</div>
					</div>	
				<?php endforeach; ?>
			</div>
		</div>
    </body>
</html>
