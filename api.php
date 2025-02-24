<?php
include 'database/connection.php';

header('Content-Type: application/json');

// Handle Vehicle Data
if (strpos($_SERVER['REQUEST_URI'], '/vehicles') !== false) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Fetch all vehicles
        $query = "SELECT * FROM vehicles";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($vehicles) {
            http_response_code(200); // OK
            echo json_encode($vehicles);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'No vehicles found']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Create a new vehicle
        $data = json_decode(file_get_contents("php://input"), true);
        $query = "INSERT INTO vehicles (model, location, status, fuel_efficiency) VALUES (:model, :location, :status, :fuel_efficiency)";
        $stmt = $pdo->prepare($query);
        
        if ($stmt->execute([
            'model' => $data['model'],
            'location' => $data['location'],
            'status' => $data['status'],
            'fuel_efficiency' => $data['fuel_efficiency']
        ])) {
            http_response_code(201); // Created
            echo json_encode(['message' => 'Vehicle created successfully']);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Failed to create vehicle']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // Update an existing vehicle
        $data = json_decode(file_get_contents("php://input"), true);
        $query = "UPDATE vehicles SET model = :model, location = :location, status = :status, fuel_efficiency = :fuel_efficiency WHERE id = :id";
        $stmt = $pdo->prepare($query);
        
        if ($stmt->execute([
            'model' => $data['model'],
            'location' => $data['location'],
            'status' => $data['status'],
            'fuel_efficiency' => $data['fuel_efficiency'],
            'id' => $data['id']
        ])) {
            http_response_code(200); // OK
            echo json_encode(['message' => 'Vehicle updated successfully']);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'Vehicle not found']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Delete a vehicle
        $data = json_decode(file_get_contents("php://input"), true);
        $query = "DELETE FROM vehicles WHERE id = :id";
        $stmt = $pdo->prepare($query);
        
        if ($stmt->execute(['id' => $data['id']])) {
            http_response_code(200); // OK
            echo json_encode(['message' => 'Vehicle deleted successfully']);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'Vehicle not found']);
        }
    }
}

// Handle Maintenance Data
if (strpos($_SERVER['REQUEST_URI'], '/maintenance') !== false) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Fetch upcoming maintenance records
        $maintenanceQuery = "SELECT * FROM maintenance WHERE due_date >= CURDATE() ORDER BY due_date ASC";
        $maintenanceStmt = $pdo->prepare($maintenanceQuery);
        $maintenanceStmt->execute();
        $upcomingMaintenance = $maintenanceStmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($upcomingMaintenance) {
            http_response_code(200); // OK
            echo json_encode($upcomingMaintenance);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'No upcoming maintenance found']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Create a new maintenance record
        $data = json_decode(file_get_contents("php://input"), true);
        $query = "INSERT INTO maintenance (vehicle_id, maintenance_type, maintenance_date, due_date, notes) VALUES (:vehicle_id, :maintenance_type, :maintenance_date, :due_date, :notes)";
        $stmt = $pdo->prepare($query);
        
        if ($stmt->execute([
            'vehicle_id' => $data['vehicle_id'],
            'maintenance_type' => $data['maintenance_type'],
            'maintenance_date' => $data['maintenance_date'],
            'due_date' => $data['due_date'],
            'notes' => $data['notes']
        ])) {
            http_response_code(201); // Created
            echo json_encode(['message' => 'Maintenance record created successfully']);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['message' => 'Failed to create maintenance record']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // Update an existing maintenance record
        $data = json_decode(file_get_contents("php://input"), true);
        $query = "UPDATE maintenance SET maintenance_type = :maintenance_type, maintenance_date = :maintenance_date, due_date = :due_date, notes = :notes WHERE id = :id";
        $stmt = $pdo->prepare($query);
        
        if ($stmt->execute([
            'maintenance_type' => $data['maintenance_type'],
            'maintenance_date' => $data['maintenance_date'],
            'due_date' => $data['due_date'],
            'notes' => $data['notes'],
            'id' => $data['id']
        ])) {
            http_response_code(200); // OK
            echo json_encode(['message' => 'Maintenance record updated successfully']);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'Maintenance record not found']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Delete a maintenance record
        $data = json_decode(file_get_contents("php://input"), true);
        $query = "DELETE FROM maintenance WHERE id = :id";
        $stmt = $pdo->prepare($query);
        
        if ($stmt->execute(['id' => $data['id']])) {
            http_response_code(200); // OK
            echo json_encode(['message' => 'Maintenance deleted successfully']);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['message' => 'Maintenance not found']);
        }
    }
}