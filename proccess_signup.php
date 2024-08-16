<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $passwords = $_POST['password'];

    $profileImage = null;
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $profileImageName = $_FILES['picture']['name'];
        $profileImageTmpName = $_FILES['picture']['tmp_name'];
        $profileImagePath = 'images/' . $profileImageName;
        move_uploaded_file($profileImageTmpName, $profileImagePath);
        $profileImage = $profileImagePath;
    }


    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'helping_hand';


    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $query = "INSERT INTO customers (name, email, phone, password, profile_image) 
              VALUES ('$name', '$email', '$phone', '$passwords', '$profileImage')";

    if ($conn->query($query) === TRUE) {

        header("Location: loginCustomer.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
