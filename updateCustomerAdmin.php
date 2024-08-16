<?php
session_start();

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'helping_hand';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customerId = $_POST['customer_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];

if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    $profileImage = $_FILES['profile_image']['name'];
    $tempFile = $_FILES['profile_image']['tmp_name'];
    $uploadPath = 'images/' . $profileImage;

    if (move_uploaded_file($tempFile, $uploadPath)) {
        $query = "UPDATE customers SET name = '$name', email = '$email', phone = '$phone', password = '$password', profile_image = '$uploadPath' WHERE id = '$customerId'";
    } else {
        $query = "UPDATE customers SET name = '$name', email = '$email', phone = '$phone', password = '$password' WHERE id = '$customerId'";
    }
} else {
    $query = "UPDATE customers SET name = '$name', email = '$email', phone = '$phone', password = '$password' WHERE id = '$customerId'";
}

if ($conn->query($query) === TRUE) {
    $_SESSION['username'] = $name;

    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "Error updating customer data: " . $conn->error;
}

$conn->close();
?>
