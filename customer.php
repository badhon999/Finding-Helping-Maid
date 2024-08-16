<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="signup-page">
        <div class="header">
            <h1>Welcome To Helping Hand</h1>
            <img src="images/helping hand logo.jpg" alt="Helping Hand Logo">
        </div>
        <div class="signup-form">
            <form action="proccess_signup.php" method="POST" enctype="multipart/form-data">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="picture">Picture:</label>
                <input type="file" id="picture" name="picture">

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
