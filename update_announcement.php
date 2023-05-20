<?php
// uses mysqli
// include the database connection file
include 'db_connection.php';
// check if user is logged in as an admin
include 'LoginCheck.php';
// include the admin navbar
include 'admin_navbar.php';

// fetch all announcements from the database
$sql = "SELECT * FROM announcements";
$result = mysqli_query($db, $sql);
$announcements = mysqli_fetch_all($result, MYSQLI_ASSOC);

// handle form submission for updating an announcement
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $announcementID = $_POST['announcementID'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $datePosted = $_POST['datePosted'];

    // update announcement in the database
    $stmt = mysqli_prepare($db, "UPDATE announcements SET title=?, description=?, datePosted=? WHERE announcementID=?");
    mysqli_stmt_bind_param($stmt, 'sssi', $title, $description, $datePosted, $announcementID);
    mysqli_stmt_execute($stmt);

    // redirect to the same page to refresh the list of announcements
    header("Location: update_announcement.php");
}

?>

<!-- HTML code to display a table with all announcements and an edit button -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin Edit Announcements</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
    <h1 class="text-center mt-5">Edit Announcements</h1>

    <table class="table table-hover border">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date Posted</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php foreach ($announcements as $announcement) { ?>
            <tr>
                <td><?php echo $announcement['announcementID']; ?></td>
                <td><?php echo $announcement['title']; ?></td>
                <td><?php echo $announcement['description']; ?></td>
                <td><?php echo date("m/d/Y", strtotime($announcement['datePosted'])); ?></td>
                <td>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editModal<?php echo $announcement['announcementID']; ?>">
                        Edit
                    </button>
                </td>
            </tr>
            <!-- Modal for editing an announcement -->
            <div class="modal" id="editModal<?php echo $announcement['announcementID']; ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Announcement</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="announcementID" value="<?php echo $announcement['announcementID']; ?>">
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $announcement['title']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea class="form-control" id="description" name="description"><?php echo $announcement['description']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="datePosted">Date Posted:</label>
                                    <input type="date" class="form-control" id="datePosted" name="datePosted" value="<?php echo date('Y-m-d'); ?>" readonly>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss='modal'>Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </table>
    <br><a href="admin_homepage.php" class="btn btn-primary">Back to Dashboard</a>
        <a href="manage_announcements.php" class="btn btn-secondary">Back to Manage Announcements</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
