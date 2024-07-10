<?php
require_once '../Config/database.php';
require_once '../Models/UserModel.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'register') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $role = $_POST['role'];

        $userModel = new UserModel();
        if ($userModel->registerUser($username, $email, $password, $role)) {
            if($role == 'customer'){
                header('Location: ../Frontend/customerLogin.html');
            }else{
                header('Location: ../Frontend/agencyLogin.html');
            }
        } else {
            echo "Registration failed.";
        }
    } elseif (isset($_POST['action']) && $_POST['action'] == 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $userModel = new UserModel();
        $user = $userModel->loginUser($username, $password);
        // echo $user, "-----";
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];


            echo "<script>
                sessionStorage.setItem('role', '{$user['role']}');
                // window.location.href = 'available_cars.html';
            </script>";

            // echo $_SESSION['role'];

            if ($user['role'] == 'customer') {
                header('Location: ../Frontend/available_cars.html');
            } else {
                header('Location: ../Frontend/add_car.html');
            }
        } else {
            echo "Login failed.";
        }
    }
}
?>
