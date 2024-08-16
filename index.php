<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helping Hand</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="maindiv">
        <nav>
            <div class="logo-container">
              <a href="index.php"><img src="images/helping hand logo.jpg" alt="Helping Hand" class="logo-img"></a>
              <p>Helping Hand</p>
            </div>
            <ul class="nav-links">
              <li><a href="#" class="Hover active">Home</a></li>
              <li><a href="about.php" class="Hover">About</a></li>
              <li><a href="searchHelpers.php" class="Hover">Helpers</a></li>
            </ul>
            <div class="login-container">
            <?php
session_start();
if(isset($_SESSION['username'])) {
    echo '<a href="customerProfile.php" class="login-btn">Profile</a>';
    echo '<a href="logout.php" class="login-btn">Log out</a>';

} else {
    echo '<a href="loginAs.php" class="login-btn">Login</a>';

}
?>
            </div>
          </nav>
          
        <section class="hero">
            <div class="hero-content">
              <h1 class="slogan">Leave the cleaning to us<br>so you can enjoy your free time.</h1>
              <a href="searchHelpers.php" class="hire-btn">Hire Us</a>
            </div>
        </section>
        
        <section class="choose-us">
            <h2 class="section-heading">WHY CHOOSE US</h2>
            <div class="choose-us-container">
              <div class="choose-us-box">
                <img  class="round-image" src="images/high quality.jpg" alt="Safe and Reliable">
                <h3 class="box-heading">SAFE AND RELIABLE</h3>
                <p class="box-paragraph">The company conducts thorough background checks on all employees, including criminal record checks and employment history verifications, to ensure that they are trustworthy and reliable.</p>
              </div>
              <div class="choose-us-box">
                <img class="safe" src="images/safe.png" alt="Safe and Reliable">
                <h3 class="box-heading">HIGH QUALITY</h3>
                <p class="box-paragraph">The company invests in the training and development of their employees, ensuring that they have the skills and knowledge necessary to provide high-quality services.</p>
              </div>
            </div>
          </section>
          
          <section class="top-helpers">
            <h2 class="section-heading" style="color: #fff;">TOP HELPERS</h2>
            <div class="card-container">

            
          <?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "helping_hand";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id,name, salary, profile_image FROM helpers LIMIT 6";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name = $row["name"];
        $salary = $row["salary"];
        $image = $row["profile_image"];
        $id= $row["id"];



        echo '<a href="maidProfile.php?id=' . $id . '" style="text-decoration: none;"><div class="card">';
        echo '<img src="images/' . $image . '" alt="' . $name . '">';
        echo '<h3 class="card-heading">' . $name . '</h3>';
        echo '<p class="card-paragraph">' . $salary . '/Month</p>';
        echo '</div></a>';
    }
} else {
    echo "No data found.";
}

$conn->close();
?>
</div>
</section>


          
          
<footer>
  <div class="footer-container">
    <div class="footer-section">
      <h2>WHO WE ARE</h2>
      <p>We are a company dedicated to providing high-quality services to our customers. Our team consists of skilled professionals who are committed to delivering excellent service and ensuring customer satisfaction. We believe that our customers deserve the best, and we strive to exceed their expectations in everything we do.</p>
    </div>
    <div class="footer-section">
      <h2 class="social-icons">FOLLOW US ON</h2>
      <div class="social-icons-wrapper"> 
      <div class="social-icons">
          <a href="http://www.facebook.com"><img src="images/FACEBOOK.PNG" alt="icon1"></a>
          <a href="http://www.instagram.com"><img src="images/insta.jpg" alt="icon2"></a>
          <a href="http://"><img src="images/whatsapp.png" alt="icon3"></a>
        </div>
      </div>
    </div>
    <div class="footer-section">
      <h2>ADDRESS</h2>
      <p>Uttara, Azompur Faydabaad Road<br>House no. 2</p>
    </div>
  </div>
</footer>

          

    </div>
</body>
</html>