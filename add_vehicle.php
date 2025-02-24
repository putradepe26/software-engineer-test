<?php
include 'connection.php';

// Handle adding a new vehicle
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_vehicle'])) {
    $model = $_POST['model'];
    $location = $_POST['location'];
    $status = $_POST['status'];
    $fuel_efficiency = $_POST['fuel_efficiency'];

    $insertQuery = "INSERT INTO vehicles (model, location, status, fuel_efficiency) VALUES (:model, :location, :status, :fuel_efficiency)";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->execute(['model' => $model, 'location' => $location, 'status' => $status, 'fuel_efficiency' => $fuel_efficiency]);

    header("Location: index.php"); // Redirect to avoid form resubmission
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Add New Vehicle</h1>
        <form method="POST" action="">
            <div class="form-group">
                    <label for="model">Vehicle Model</label>
                    <input type="text" class="form-control" id="model" name="model" required>
                </div>
                <div class="form-group">
                    <label for="model">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Available">Available</option>
                        <option value="In Use">In Use</option>
                        <option value="Under Maintenance">Under Maintenance</option>
                        <option value="Out of Service">Out of Service</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fuel_efficiency">Fuel Efficiency (Liters)</label>
                    <input type="number" class="form-control" id="fuel_efficiency" name="fuel_efficiency" step="0.01" required>
                </div>
                <button type="submit" name="add_vehicle" class="btn btn-primary">Add Vehicle</button>
        </form>
    </div>
</body>