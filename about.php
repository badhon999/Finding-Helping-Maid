<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="logo-container">
        <a href="index.php"><img src="images/helping hand logo.jpg" alt="Helping Hand" class="logo-img"></a>
          <p>Helping Hand</p>
        </div>
        <ul class="nav-links">
          <li><a href="index.php" class="Hover">Home</a></li>
          <li><a href="#" class="Hover active">About</a></li>
          <li><a href="searchHelpers.php" class="Hover">Helpers</a></li>
        </ul>
        <div class="login-container">
        <?php
session_start();
if(isset($_SESSION['username'])) {

    echo '<a href="logout.php" class="login-btn">Log out</a>';

} else {
    echo '<a href="loginAs.php" class="login-btn">Login</a>';

}
?>
        </div>
      </nav>

      <section class="about-us-section">
		<div class="container">
			<p>
                At Helping Hand, we understand that finding reliable and trustworthy maid services can be a daunting task, especially when you're pressed for time. That's why we're committed to providing you with high-quality, customizable maid services that are tailored to your unique needs. <br>
                Our team of experienced and skilled maids are fully trained, insured, and dedicated to ensuring that your home is not only spotless but also safe. We only use the best, eco-friendly cleaning products and equipment to keep your home looking and feeling fresh and clean, without harming the environment or your health. <br>
                Our affordable pricing and flexible scheduling options make it easy for you to get the cleaning services you need, when you need them. Whether you need a one-time deep cleaning, a recurring cleaning service, or just some help with laundry or dishes, we've got you covered. <br>
                At Helping Hand, we take pride in our work and always go above and beyond to exceed your expectations. We're committed to your complete satisfaction and will do everything we can to ensure that you're happy with our services. <br>
                So why choose us? Our commitment to quality, affordability, and customer satisfaction sets us apart from the competition. Let us show you how we can make a difference in your life by providing you with the best maid services in town. Contact us today to learn more and schedule your cleaning service. <br>
            </p>
		</div>
	</section>
</body>
</html>