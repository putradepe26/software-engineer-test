<?php
include 'database/connection.php';

// Fetch vehicle table
$query = "SELECT * FROM vehicles";
$stmt = $pdo->prepare($query);
$stmt->execute();
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch maintenance table
$maintenanceQuery = "SELECT * FROM maintenance WHERE due_date >= CURDATE() ORDER BY due_date ASC";
$maintenanceStmt = $pdo->prepare($maintenanceQuery);
$maintenanceStmt->execute();
$upcomingMaintenance = $maintenanceStmt->fetchAll(PDO::FETCH_ASSOC);


// Handle status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $vehicleId = $_POST['vehicle_id'];
    $vehicleId = $_POST['location'];
    $newStatus = $_POST['status'];

    $updateQuery = "UPDATE vehicles SET status = :status WHERE id = :id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute(['status' => $newStatus, 'location' => $newLocation,'id' => $vehicleId]);

    header("Location: index.php"); // Redirect to avoid form resubmission
    exit();
}

// Handle deleting a vehicle
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_vehicle'])) {
    $vehicleId = $_POST['vehicle_id'];

    $deleteQuery = "DELETE FROM vehicles WHERE id = :id";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->execute(['id' => $vehicleId]);

    header("Location: index.php"); // Redirect to avoid form resubmission
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coal Haul Management Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Coal Haul Management Dashboard</h1>

        <!-- Add Vehicle Form -->
        <section class="mt-4">
            <h2>Vehicle Data</h2>
            <a href="add_vehicle.php" class="btn btn-primary mb-3">Add New Vehicle</a>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Vehicle ID</th>
                        <th>Model</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Fuel Efficiency (Liters)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($vehicle['id']); ?></td>
                            <td><?php echo htmlspecialchars($vehicle['model']); ?></td>
                            <td><?php echo htmlspecialchars($vehicle['location']); ?></td>
                            <td><?php echo htmlspecialchars($vehicle['status']); ?></td>
                            <td><?php echo htmlspecialchars($vehicle['fuel_efficiency']); ?></td>
                            <td>
                                <a href="update_vehicle.php?id=<?php echo htmlspecialchars($vehicle['id']); ?>" class="btn btn-warning">Update</a>
                                <form method="POST" action="delete.php" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($vehicle['id']); ?>">
                                    <button type="submit" name="delete_vehicle" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>


        <section class="mt-4">
            <h2>Maintenance Vehicle</h2>
            <a href="add_maintenance.php" class="btn btn-primary mb-3">Add Maintenance</a>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Vehicle ID</th>
                        <th>Maintenance Type</th>
                        <th>Maintenance Date</th>
                        <th>Due Date</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($upcomingMaintenance as $maintenance): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($maintenance['vehicle_id']); ?></td>
                            <td><?php echo htmlspecialchars($maintenance['maintenance_type']); ?></td>
                            <td><?php echo htmlspecialchars($maintenance['maintenance_date']); ?></td>
                            <td><?php echo htmlspecialchars($maintenance['due_date']); ?></td>
                            <td><?php echo htmlspecialchars($maintenance['notes']); ?></td>
                            <td>
                                <a href="update_maintenance.php?id=<?php echo htmlspecialchars($maintenance['id']); ?>" class="btn btn-warning">Update</a>
                                <form method="POST" action="delete2.php" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($maintenance['id']); ?>">
                                    <button type="submit" name="delete_maintenance" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>