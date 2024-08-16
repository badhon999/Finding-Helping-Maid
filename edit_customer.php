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

$previousName = '';
$previousEmail = '';
$previousPhone = '';
$previousPassword = '';
$previousProfileImage = '';

if (isset($_GET['id'])) {
    $customerId = $_GET['id'];

    $customerQuery = "SELECT name, email, phone, password, profile_image FROM customers WHERE id = '$customerId'";
    $customerResult = $conn->query($customerQuery);

    if ($customerResult->num_rows > 0) {
        $customerData = $customerResult->fetch_assoc();
        $previousName = $customerData['name'];
        $previousEmail = $customerData['email'];
        $previousPhone = $customerData['phone'];
        $previousPassword = $customerData['password'];
        $previousProfileImage = $customerData['profile_image'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
    <style>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F2F2F2;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 40px;
        }

        form {
            max-width: 400px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    </style>
</head>
<body>
    <h1>Update Customer</h1>
    
    <form action="updateCustomerAdmin.php" method="post" enctype="multipart/form-data">
        <?php  ?>
        <input type="hidden" name="customer_id" value="<?php echo $customerId; ?>">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $previousName; ?>"><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $previousEmail; ?>"><br>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $previousPhone; ?>"><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $previousPassword; ?>"><br>
        
        <label for="profile_image">Profile Image:</label>
        <input type="file" id="profile_image" name="profile_image"><br>
        
        <input type="submit" value="Update">
    </form>
</body>
</html>

<?php
$conn->close();
?>
