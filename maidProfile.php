<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maid Profile</title>
    <style>
        body {
            background-color: #C70039;
            color: white;
        }

        .profile-container {
            display: flex;
            align-items: center;
            padding: 20px;
        }

        .profile-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .profile-details {
            flex-grow: 1;
        }

        .section {
            margin: 20px;
        }

        .section-heading {
            font-size: 24px;
        }

        .service-list {
            margin-top: 10px;
            list-style-type: disc;
            padding-left: 20px;
        }

        .description {
            margin-top: 20px;
        }

        .hire-button {
            background-color: #900C3F;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: error.php");
        exit();
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "helping_hand";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT name, salary, profile_image, description FROM helpers WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            $name = $row["name"];
            $salary = $row["salary"];
            $image = $row["profile_image"];
            $description = $row["description"];

            $sql = "SELECT service_name FROM services WHERE helper_id = $id";
            $result = $conn->query($sql);
            $services = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $services[] = $row["service_name"];
                }
            }
        } else {
            header("Location: error.php");
            $conn->close();
            exit();
        }

        $conn->close();
    } else {
        header("Location: error.php");
        exit();
    }

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
    } else {
        header("Location: error.php");
        $conn->close();
        exit();
    }

    $conn->close();
    ?>

    <div class="profile-container">
        <img src="images/<?php echo $image; ?>" alt="<?php echo $name; ?>" class="profile-image">
        <div class="profile-details">
            <h2><?php echo $name; ?></h2>
            <p>Salary/Month: <?php echo $salary; ?></p>
            <div class="section">
                <h2 class="section-heading">Services</h2>
                <ul class="service-list">
                    <?php foreach ($services as $service) : ?>
                        <li><?php echo $service; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <form action="hire.php" method="post">
                <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
                <input type="hidden" name="maid_id" value="<?php echo $id; ?>">
                <button type="submit" class="hire-button">Hire Me</button>
            </form>
        </div>
    </div>

    <div class="section description">
        <h2 class="section-heading">Description</h2>
        <p><?php echo $description; ?></p>
    </div>
</body>

</html>
