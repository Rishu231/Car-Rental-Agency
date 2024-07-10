<?php
class CarModel {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function addCar($agency_id, $model, $vehicle_number, $seating_capacity, $rent_per_day) {
        $stmt = $this->conn->prepare("INSERT INTO cars (agency_id, model, vehicle_number, seating_capacity, rent_per_day) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $agency_id, $model, $vehicle_number, $seating_capacity, $rent_per_day);
        return $stmt->execute();
    }

    public function getAvailableCars() {
        $result = $this->conn->query("SELECT * FROM cars");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCarById($car_id) {
        $stmt = $this->conn->prepare("SELECT * FROM cars WHERE id = ?");
        $stmt->bind_param("i", $car_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
