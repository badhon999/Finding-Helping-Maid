<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helper Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <nav class="navbar">
    <div class="logo">
    <a href="index.php"><img src="images/helping hand logo.jpg" alt="Helping Hand" class="logo-img"></a>
      <span>Helping Hand</span>
    </div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="#" class="Hover active">Helpers</a></li>
    </ul>
    <?php
session_start();
if(isset($_SESSION['username'])) {

    echo '<a href="logout.php" class="login-btn">Log out</a>';

} else {
    echo '<a href="loginAs.php" class="login-btn">Login</a>';

}
?>
    </nav>

    <section class="categories-section">
    <form action="" method="post">
    <h2>CATEGORIES</h2>
    <div class="categories">
      <div class="category">
        <h3>Gender</h3>
        <input type="radio" name="gender" id="male" value="male">
        <label for="male">Male</label>
        <input type="radio" name="gender" id="female" value="female">
        <label for="female">Female</label>
      </div>
      <div class="category">
        <h3>Salary</h3>
        <input type="radio" name="salary" id="1k" value="1k">
        <label for="male">1000-3000</label><br>
        <input type="radio" name="salary" id="3k" value="3k">
        <label for="female">3000-5000</label><br>
        <input type="radio" name="salary" id="5k" value="5k">
        <label for="female">5000-7000</label><br>
        
  
      </div>
      <div class="category">
        <h3>Services</h3>
        <input type="checkbox" id="homeCleaning" name="services" value="home">
            <label for="homeCleaning">Home Cleaning</label><br/>
      
            <input type="checkbox" id="officeCleaning" name="services" value="office">
            <label for="officeCleaning">Office Cleaning</label><br/>
      
            <input type="checkbox" id="laundryService" name="services" value="laundry">
            <label for="laundryService">Laundry Service</label><br/>
      
            <input type="checkbox" id="cooking" name="services" value="cooking">
            <label for="cooking">Cooking</label><br/>
      
            <input type="checkbox" id="greenCleaning" name="services" value="green">
            <label for="greenCleaning">Green Cleaning</label><br/>
            <button type="submit" class="search-btn">Search</button>
      </div>
    </div>
    </form>
  </section>

    <section class="helper-cards-section">
        <h2 class="helper-cards-heading">Helper Cards</h2>
        <div class="helper-cards">
        <?php

if (!isset($_SESSION['username'])) {
    header("Location: error.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $salary = isset($_POST['salary']) ? $_POST['salary'] : '1k';
    $services = isset($_POST['services']) ? $_POST['services'] : ['home', 'office', 'laundry', 'cooking', 'green'];

    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'helping_hand';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $salaryRange = '';
    if ($salary === '1k') {
        $salaryRange = "salary BETWEEN 1000 AND 3000";
    } elseif ($salary === '3k') {
        $salaryRange = "salary BETWEEN 3000 AND 5000";
    } elseif ($salary === '5k') {
        $salaryRange = "salary BETWEEN 5000 AND 7000";
    }

    $servicesStr = "'" . implode("', '", (array)$services) . "'";
    $servicesLikeStr = "'" . implode("%' OR service_name LIKE '%", (array)$services) . "%'";

    if ($gender === '') {
        $query = "SELECT * FROM helpers WHERE ($salaryRange) AND id IN (SELECT helper_id FROM services WHERE service_name LIKE $servicesLikeStr)";
    } else {
        $query = "SELECT * FROM helpers WHERE gender='$gender' AND ($salaryRange) AND id IN (SELECT helper_id FROM services WHERE service_name LIKE $servicesLikeStr)";
    }

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $salary = $row["salary"];
            $image = $row["profile_image"];
            $id= $row["id"];

            echo '<a href="maidProfile.php?id=' . $id . '" style="text-decoration: none;"><div class="helper-card">';
            echo '<img src="images/' . $image . '" alt="' . $name . '">';
            echo '<h3 class="helper-name">' . $name . '</h3>';
            echo '<p class="helper-salary">' . $salary . '/Month</p>';
            echo '</div></a>';
        }
    } else {
        echo "No helpers found.";
    }

    $conn->close();
} else {
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'helping_hand';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM helpers WHERE salary BETWEEN 1000 AND 10000";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $salary = $row["salary"];
            $image = $row["profile_image"];
            $id= $row["id"];

            echo '<a href="maidProfile.php?id=' . $id . '" style="text-decoration: none;"><div class="helper-card">';
            echo '<img src="images/' . $image . '" alt="' . $name . '">';
            echo '<h3 class="helper-name">' . $name . '</h3>';
            echo '<p class="helper-salary">' . $salary . '/Month</p>';
            echo '</div></a>';
        }
    } else {
        echo "No helpers found.";
    }

    $conn->close();
}
?>




        </div>
    </section>

    <footer>
        <p>&copy; 2023 Helping Hand. All rights reserved.</p>
    </footer>

</body>
</html>
