<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['id']; 
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $salary = isset($_POST['salary']) ? $_POST['salary'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';


    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'helping_hand';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $updateQuery = "UPDATE helpers SET name = '$name', salary = '$salary', description = '$description' WHERE id = '$id'";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult) {

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $imageFile = $_FILES['profile_image']['tmp_name'];
            $imageFileName = $_FILES['profile_image']['name'];

            $uploadDir = 'images/';
            $uploadPath = $uploadDir . $imageFileName;

            if (move_uploaded_file($imageFile, $uploadPath)) {

                $updateImageQuery = "UPDATE helpers SET profile_image = '$imageFileName' WHERE id = '$id'";
                $conn->query($updateImageQuery);
            }
        }

        if (isset($_POST['services'])) {
            $selectedServices = $_POST['services'];
            $selectedServices = array_map('trim', $selectedServices); 
            $deleteServicesQuery = "DELETE FROM services WHERE helper_id = '$id'";
            $conn->query($deleteServicesQuery);

     
            foreach ($selectedServices as $service) {
                $insertServiceQuery = "INSERT INTO services (helper_id, service_name) VALUES ('$id', '$service')";
                $conn->query($insertServiceQuery);
            }
        }


        header("Location: helperProfile.php?id=$id");
        exit();
    } else {
       
    }

    $conn->close();
} else {
    
    $id = $_SESSION['id'];

   
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'helping_hand';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $selectQuery = "SELECT * FROM helpers WHERE id = '$id'";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $salary = $row['salary'];
        $description = $row['description'];
    } else {
        
    }

    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Helper</title>
</head>
<style>
        * {
            box-sizing: border-box;
            color: black;
        }
        
        body {
            background-color: #C70039;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .edit-page {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .edit-page h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .edit-page form {
            display: grid;
            gap: 15px;
        }

        .edit-page input[type="text"],
        .edit-page textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .edit-page textarea {
            resize: vertical;
        }

        .edit-page input[type="file"] {
            margin-bottom: 15px;
        }

        .edit-page h3 {
            margin-bottom: 10px;
        }

        .edit-page .services label {
            display: block;
        }

        .edit-page button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-page button[type="submit"]:hover {
            background-color: #45a049;
        }

    </style>
<body>
    <div class="edit-page">
        <h1>Edit Helper</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name" value="<?php echo isset($name) ? $name : ''; ?>" required>
            <input type="text" name="salary" placeholder="Salary" value="<?php echo isset($salary) ? $salary : ''; ?>" required>
            <textarea name="description" placeholder="Description" required><?php echo isset($description) ? $description : ''; ?></textarea>
            <input type="file" name="profile_image">
            <h3>Services:</h3>
        
                <div class="services">
                    <input type="checkbox" id="homeCleaning" name="services[]" value="Home Cleaning">
                    <label for="homeCleaning">Home Cleaning</label><br>

                    <input type="checkbox" id="officeCleaning" name="services[]" value="Office Cleaning">
                    <label for="officeCleaning">Office Cleaning</label><br>

                    <input type="checkbox" id="laundryService" name="services[]" value="Laundry Service">
                    <label for="laundryService">Laundry Service</label><br>

                    <input type="checkbox" id="cooking" name="services[]" value="Cooking">
                    <label for="cooking">Cooking</label><br>

                    <input type="checkbox" id="greenCleaning" name="services[]" value="Green Cleaning">
                    <label for="greenCleaning">Green Cleaning</label><br>
                </div>

            <button type="submit" >Save</button>
        </form>
    </div>
</body>
</html>
