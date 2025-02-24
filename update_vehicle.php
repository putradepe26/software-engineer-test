<?php
include 'database/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];
    $model = $_POST['model'];
    $location = $_POST['location'];
    $status = $_POST['status'];
    $fuel_efficiency = $_POST['fuel_efficiency'];

    $query = "UPDATE vehicles SET model = :model, location = :location, status = :status, fuel_efficiency = :fuel_efficiency WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['model' => $model, 'location' => $location, 'status' => $status, 'fuel_efficiency' => $fuel_efficiency, 'id' => $id]);
    
    header("Location: index.php");
    exit();
}

// Fetch vehicle data for the form
$id = $_GET['id'];
$query = "SELECT * FROM vehicles WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);
$vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Vehicle</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Update Vehicle</h2>
        <form method="POST" action="">
            <input type="hidden" name="vehicle_id" value="<?php echo htmlspecialchars($vehicle['id']); ?>">
            <div class="form-group">
                <label for="model">Vehicle Model</label>
                <input type="text" class="form-control" id="model" name="model" value="<?php echo htmlspecialchars($vehicle['model']); ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($vehicle['location']); ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Available" <?php echo $vehicle['status'] == 'Available' ? 'selected' : ''; ?>>Available</option>
                    <option value="In Use" <?php echo $vehicle['status'] == 'In Use' ? 'selected' : ''; ?>>In Use</option>
                    <option value="Under Maintenance" <?php echo $vehicle['status'] == 'Under Maintenance' ? 'selected' : ''; ?>>Under Maintenance</option>
                    <option value="Out of Service" <?php echo $vehicle['status'] == 'Out of Service' ? 'selected' : ''; ?>>Out of Service</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fuel_efficiency">Fuel Efficiency (Liters)</label>
                <input type="number" class="form-control" id="fuel_efficiency" name="fuel_efficiency" value="<?php echo htmlspecialchars($vehicle['fuel_efficiency']); ?>" step="0.01" required>
            </div>
            <button type="submit" name="update_vehicle" class="btn btn-primary">Update Vehicle</button>
        </form>
    </div>
</body>
</html>