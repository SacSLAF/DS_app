<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'general') {
    header("Location: ../login.php");
    exit();
}

include '../config.php';

// Fetch family details based on the ID from the URL
$family_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$family_sql = "SELECT * FROM families WHERE id = ?";
$family_stmt = $conn->prepare($family_sql);
$family_stmt->bind_param("i", $family_id);
$family_stmt->execute();
$family_result = $family_stmt->get_result();
$family = $family_result->fetch_assoc();

// Fetch family members details
$members_sql = "SELECT * FROM family_members WHERE family_id = ?";
$members_stmt = $conn->prepare($members_sql);
$members_stmt->bind_param("i", $family_id);
$members_stmt->execute();
$members_result = $members_stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Family Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Family Details</h2>
        <?php
        $dashboardLink = ($_SESSION['role'] === 'admin') ? 'admin_dashboard.php' : 'dashboard.php';
        ?>

        <a href="<?php echo $dashboardLink; ?>" class="btn btn-primary mb-4">Back to Dashboard</a>

        <!-- <a href="admin_dashboard.php" class="btn btn-primary mb-4">Back to Dashboard</a> -->

        <?php if ($family): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Householder: <?php echo htmlspecialchars($family['main_person_name']); ?></h4>
                </div>
                <div class="card-body">
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($family['home_address']); ?></p>
                </div>
            </div>

            <h4>Family Members</h4>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Marital Status</th>
                        <th>Occupation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($members_result->num_rows > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($member = $members_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($member['name']); ?></td>
                                <td><?php echo htmlspecialchars($member['age']); ?></td>
                                <td><?php echo htmlspecialchars($member['marital_status']); ?></td>
                                <td><?php echo htmlspecialchars($member['occupation']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No family members found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                Family not found.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>