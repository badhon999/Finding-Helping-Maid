<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'helping_hand';

$conn = new mysqli($servername, $username, $password, $dbname);
if (isset($_GET['maid_id'])) {
    $maidId = $_GET['maid_id'];

   
    $query = "DELETE FROM hire WHERE maid_id = '$maidId'";
    $result = $conn->query($query);

    if ($result) {
       
        header("Location: customerProfile.php");
        exit;
    } else {
       
        echo "Error deleting hire data: " . $conn->error;
    }
} else {
    
    echo "Invalid request";
}
?>
