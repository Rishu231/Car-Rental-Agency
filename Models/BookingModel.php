<?php
class BookingModel {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function rentCar($customer_id, $car_id, $start_date, $number_of_days, $total_rent) {
        $stmt = $this->conn->prepare("INSERT INTO bookings (customer_id, car_id, start_date, number_of_days, total_rent) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisid", $customer_id, $car_id, $start_date, $number_of_days, $total_rent);
        return $stmt->execute();
    }

    public function getBookingsByAgency($agency_id) {
        $stmt = $this->conn->prepare("SELECT b.*, c.model, c.vehicle_number, u.username AS customer_name FROM bookings b JOIN cars c ON b.car_id = c.id JOIN users u ON b.customer_id = u.id");
        $stmt->bind_param("i", $agency_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
