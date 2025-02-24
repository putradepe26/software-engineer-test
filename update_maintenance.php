<?php
include 'database/connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $vehicleId = $_POST['vehicle_id'];
    $maintenanceType = $_POST['maintenance_type'];
    $maintenanceDate = $_POST['maintenance_date'];
    $dueDate = $_POST['due_date'];
    $notes = $_POST['notes'];

    $updateQuery = "UPDATE maintenance SET vehicle_id = :vehicle_id, maintenance_type = :maintenance_type, maintenance_date = :maintenance_date, due_date = :due_date, notes = :notes WHERE id = :id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute(['vehicle_id' => $vehicleId, 'maintenance_type' => $maintenanceType, 'maintenance_date' => $maintenanceDate, 'due_date' => $dueDate, 'notes' => $notes, 'id' => $maintenanceId]);
    
    header("Location: index.php");
    exit();

    // Fetch vehicle data for the form
    $id = $_GET['id'];
    $updateQuery = "SELECT * FROM maintenance WHERE id = :id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute(['id' => $id]);
    $maintenance = $updateStmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Maintenance Vehicle</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Update Maintenance</h1>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($maintenance['id']); ?>">
        <div class="form-group">
            <label for="vehicle_id">Vehicle ID</label>
            <input type="text" class="form-control" name="vehicle_id" value="<?php echo htmlspecialchars($maintenance['vehicle_id']); ?>" required>
        </div>
        <div class="form-group">
                    <label for="status">Maintenance Type</label>
                    <select class="form-control" id="maintenance_type" name="maintenance_type" required>
                        <option value="Oil Change" <?php echo $vehicle['maintenance_type'] == 'Available' ? 'selected' : ''; ?>>Oil Change</option>
                        <option value="Tire Rotation" <?php echo $vehicle['maintenance_type'] == 'Available' ? 'selected' : ''; ?>>Tire Rotation</option>
                        <option value="Brake Repair" <?php echo $vehicle['maintenance_type'] == 'Available' ? 'selected' : ''; ?>>Brake Repair</option>
                        <option value="Engine Repair" <?php echo $vehicle['maintenance_type'] == 'Available' ? 'selected' : ''; ?>>Engine Repair</option>
                    </select>
                </div>
        <div class="form-group">
            <label for="maintenance_date">Maintenance Date</label>
            <input type="date" class="form-control" name="maintenance_date" value="<?php echo htmlspecialchars($maintenance['maintenance_date']); ?>" required>
        </div>
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" class="form-control" name="due_date" value="<?php echo htmlspecialchars($maintenance['maintenance_due']); ?>" required>
        </div>
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea class="form-control" name="notes" value="<?php echo htmlspecialchars($maintenance['notes']); ?>"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Maintenance</button>
    </form>
</div>
</body>
</html>