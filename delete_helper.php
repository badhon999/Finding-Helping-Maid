<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin.php");
    exit();
}


if (isset($_GET['id'])) {
    $customerId = $_GET['id'];

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'helping_hand';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $deleteH = "DELETE FROM hire WHERE maid_id = '$customerId'";
    if ($conn->query($deleteH) === TRUE) {


    }
    $deleteS = "DELETE FROM services WHERE helper_id = '$customerId'";
    if ($conn->query($deleteS) === TRUE) {
      

    } 
    $deleteQuery = "DELETE FROM helpers WHERE id = '$customerId'";

    if ($conn->query($deleteQuery) === TRUE) {
        $_SESSION['success_message'] = "Customer deleted successfully.";

    } else {
        $_SESSION['error_message'] = "Failed to delete customer.";
    }

    $conn->close();
}

header("Location: admin_dashboard.php");
exit();
?>
