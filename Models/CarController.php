<?php
require_once '../Config/database.php';
require_once '../Models/CarModel.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['role'] != 'agency') {
        header('Location: ../Frontend/customerLogin.html');
        exit();
    }

    $agency_id = $_SESSION['user_id'];
    $model = $_POST['model'];
    $vehicle_number = $_POST['vehicle_number'];
    $seating_capacity = $_POST['seating_capacity'];
    $rent_per_day = $_POST['rent_per_day'];

    $carModel = new CarModel();
    if ($carModel->addCar($agency_id, $model, $vehicle_number, $seating_capacity, $rent_per_day)) {
        header('Location: ../Frontend/add_car.html');
    } else {
        echo "Failed to add car.";
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'list') {
    $carModel = new CarModel();
    $cars = $carModel->getAvailableCars();
    echo json_encode($cars);
}
?>
