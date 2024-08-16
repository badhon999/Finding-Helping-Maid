<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="login-page helper" >
        <div class="header">
            <h1>Welcome To Helping Hand</h1>
            <img src="images/helping hand logo.jpg" alt="Helping Hand Logo">
        </div>
        <div class="login-form">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="salary">Salary:</label>
                <input type="text" id="salary" name="salary" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="5" required></textarea>

                <label for="profile_image">Profile Image:</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*" required>

                <label>Services:</label>
                <div class="services">
                    <input type="checkbox" id="homeCleaning" name="services[]" value="Home Cleaning">
                    <label for="homeCleaning">Home Cleaning</label>

                    <input type="checkbox" id="officeCleaning" name="services[]" value="Office Cleaning">
                    <label for="officeCleaning">Office Cleaning</label>

                    <input type="checkbox" id="laundryService" name="services[]" value="Laundry Service">
                    <label for="laundryService">Laundry Service</label>

                    <input type="checkbox" id="cooking" name="services[]" value="Cooking">
                    <label for="cooking">Cooking</label>

                    <input type="checkbox" id="greenCleaning" name="services[]" value="Green Cleaning">
                    <label for="greenCleaning">Green Cleaning</label>
                </div>

                <label for="gender">Gender:</label>
                <div class="gender">
                    <input type="radio" id="male" name="gender" value="Male" required>
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="Female" required>
                    <label for="female">Female</label>
                </div>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'helping_hand';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $passwords = $_POST['password'];
    $salary = $_POST['salary'];
    $description = mysqli_real_escape_string($conn, $_POST['description']); // Escape special characters in the description

    if ($_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['profile_image']['name'];
        $image_tmp_name = $_FILES['profile_image']['tmp_name'];
        $image_path = 'images/' . $image_name;
        move_uploaded_file($image_tmp_name, $image_path);
    } else {
        $image_path = null;
    }

   
    if (!preg_match('/^\d{11}$/', $phone)) {
        echo "<script>alert('Invalid phone number. Phone number must be 11 digits.');</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (strtoupper($email) === $email) {
            echo "<script>alert('Invalid email address.');</script>";
            exit();
        }
        echo "<script>alert('Invalid email address.');</script>";
        exit();
    }

    $query = "INSERT INTO helpers (name, email, phone, gender, password, salary, description, profile_image) 
              VALUES ('$name', '$email', '$phone', '$gender', '$passwords', '$salary', '$description', '$image_name')";

    if ($conn->query($query) === TRUE) {
        $helper_id = $conn->insert_id;

        if (isset($_POST['services'])) {
            $services = $_POST['services'];

            foreach ($services as $service) {
                $query = "INSERT INTO services (helper_id, service_name) VALUES ('$helper_id', '$service')";
                $conn->query($query);
            }
        }

        echo "Account created successfully!";
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $conn->close();
}
?>




</body>
</html>
