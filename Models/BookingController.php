<?php
require_once '../Config/database.php';
require_once '../Models/BookingModel.php';
require_once '../Models/CarModel.php';

session_start();
// echo "-----";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // echo $_GET['action'];
    if ($_SESSION['role'] != 'customer') {
        header('Location: ../Frontend/customerLogin.html');
        exit();
    }

    $customer_id = $_SESSION['user_id'];
    $car_id = $_POST['car_id'];
    $start_date = $_POST['start_date'];
    $number_of_days = $_POST['number_of_days'];

    $carModel = new CarModel();
    $car = $carModel->getCarById($car_id);
    $total_rent = $car['rent_per_day'] * $number_of_days;

    $bookingModel = new BookingModel();
    if ($bookingModel->rentCar($customer_id, $car_id, $start_date, $number_of_days, $total_rent)) {
        header('Location: ../Frontend/available_cars.html');
    } else {
        echo "Failed to rent car.";
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'viewbooked') {
    if ($_SESSION['role'] != 'agency') {
        header('Location: ../Frontend/agencyLogin.html');
        exit();
    }

    $agency_id = $_SESSION['user_id'];
    $bookingModel = new BookingModel();
    $bookings = $bookingModel->getBookingsByAgency($agency_id);
    echo json_encode($bookings);
}
?>
