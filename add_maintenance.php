<?php
include 'database/connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vehicleId = $_POST['vehicle_id'];
    $maintenanceType = $_POST['maintenance_type'];
    $maintenanceDate = $_POST['maintenance_date'];
    $dueDate = $_POST['due_date'];
    $notes = $_POST['notes'];

    $insertQuery = "INSERT INTO maintenance (vehicle_id, maintenance_type, maintenance_date, due_date, notes) VALUES (:vehicle_id, :maintenance_type, :maintenance_date, :due_date, :notes)";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->execute(['vehicle_id' => $vehicleId, 'maintenance_type' => $maintenanceType, 'maintenance_date' => $maintenanceDate, 'due_date' => $dueDate, 'notes' => $notes]);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Maintenance Vehicle</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Add New Maintenance</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="vehicle_id">Vehicle ID</label>
            <input type="text" class="form-control" name="vehicle_id" required>
        </div>
        <div class="form-group">
                    <label for="status">Maintenance Type</label>
                    <select class="form-control" id="maintenance_type" name="maintenance_type" required>
                        <option value="Oil Change">Oil Change</option>
                        <option value="Tire Rotation">Tire Rotation</option>
                        <option value="Brake Repair">Brake Repair</option>
                        <option value="Engine Repair">Engine Repair</option>
                    </select>
                </div>
        <div class="form-group">
            <label for="maintenance_date">Maintenance Date</label>
            <input type="date" class="form-control" name="maintenance_date" required>
        </div>
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" class="form-control" name="due_date" required>
        </div>
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea class="form-control" name="notes"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Maintenance</button>
    </form>
</div>
</body>
</html>