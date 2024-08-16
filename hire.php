<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: error.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'helping_hand';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $username = $_SESSION['username'];
    $sql = "SELECT id FROM customers WHERE name = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customer_id = $row["id"];
    }
    $maid_id = $_POST['maid_id'];

    $stmt = $conn->prepare("INSERT INTO hire (customer_id, maid_id) VALUES (?, ?)");
    $stmt->bind_param("ss", $customer_id, $maid_id);

    if ($stmt->execute()) {
        echo "Hiring successful!";
        $stmt->close();
        $conn->close();
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
        $stmt->close();
        $conn->close();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
