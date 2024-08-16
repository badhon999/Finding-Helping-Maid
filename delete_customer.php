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
    $delete = "DELETE FROM hire WHERE customer_id = '$customerId'";
    if ($conn->query($delete) === TRUE) {
      

    }
    $deleteQuery = "DELETE FROM customers WHERE id = '$customerId'";

    if ($conn->query($deleteQuery) === TRUE) {
       

    } else {
        $_SESSION['error_message'] = "Failed to delete customer.";
    }

    $conn->close();
}

header("Location: admin_dashboard.php");
exit();
?>
