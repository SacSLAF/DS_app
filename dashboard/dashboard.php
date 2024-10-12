<?php
session_start();
include '../config.php';

// Check if the user is logged in as admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'general') {
    header("Location: login.php");
    exit();
}


// Fetch family details
$sql = "SELECT * FROM families";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Family Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Admin Dashboard - Family Details</h2>
            <a href="../logout.php" class="btn btn-danger">Logout</a>
        </div>


        <!-- <?php if (isset($_GET['update']) && $_GET['update'] == 'success'): ?>
            <div class="alert alert-success" role="alert">
                Family details updated successfully!
            </div>
        <?php endif; ?> -->

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Householder's Name</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['main_person_name']; ?></td>
                            <td><?php echo $row['home_address']; ?></td>
                            <td>
                                <a href="view_family.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No family details found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>