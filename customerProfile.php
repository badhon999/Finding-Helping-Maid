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

$customerUsername = $_SESSION['username'];
$customerQuery = "SELECT id, name, profile_image FROM customers WHERE name = '$customerUsername'";
$customerResult = $conn->query($customerQuery);

$customerData = $customerResult->fetch_assoc();
$customerId = $customerData['id'];
$customerName = $customerData['name'];
$customerProfileImage = $customerData['profile_image'];

$hireQuery = "SELECT helpers.id, helpers.profile_image, helpers.name, helpers.salary FROM hire
              INNER JOIN helpers ON hire.maid_id = helpers.id
              WHERE hire.customer_id = '$customerId'";
$hireResult = $conn->query($hireQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            background-color: #C70039;
        }

        .profile-container {
            display: flex;
            align-items: center;
            margin-left: 35%;
            padding: 20px;
        }

        .profile-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin-right: 20px;
        }

        h2 {
            color: white;
        }

        .profile-details {
            flex-grow: 1;
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
        .hiring{
            margin-top:5%;
        }
        table {
            border-spacing: 1;
            border-collapse: collapse;
            background: white;
            border-radius: 6px;
            overflow: hidden;
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
            position: relative;
        }

        table * {
            position: relative;
        }

        table td,
        table th {
            padding-left: 8px;
        }

        table thead tr {
            height: 60px;
            background: #FFED86;
            font-size: 16px;
        }

        table tbody tr {
            height: 48px;
            border-bottom: 1px solid #E3F1D5;
        }

        table tbody tr:last-child {
            border: 0;
        }

        table td,
        table th {
            text-align: left;
        }

        table td.l,
        table th.l {
            text-align: right;
        }

        table td.c,
        table th.c {
            text-align: center;
        }

        table td.r,
        table th.r {
            text-align: center;
        }

        @media screen and (max-width: 35.5em) {
            table {
                display: block;
            }

            table > *,
            table tr,
            table td,
            table th {
                display: block;
            }

            table thead {
                display: none;
            }

            table tbody tr {
                height: auto;
                padding: 8px 0;
            }

            table tbody tr td {
                padding-left: 45%;
                margin-bottom: 12px;
            }

            table tbody tr td:last-child {
                margin-bottom: 0;
            }

            table tbody tr td:before {
                position: absolute;
                font-weight: 700;
                width: 40%;
                left: 10px;
                top: 0;
            }

            table tbody tr td:nth-child(1):before {
                content: "Code";
            }

            table tbody tr td:nth-child(2):before {
                content: "Stock";
            }

            table tbody tr td:nth-child(3):before {
                content: "Cap";
            }

            table tbody tr td:nth-child(4):before {
                content: "Inch";
            }

            table tbody tr td:nth-child(5):before {
                content: "Box Type";
            }
        }

        body {
            font: 400 14px 'Calibri', 'Arial';
            padding: 20px;
        }

        blockquote {
            color: white;
            text-align: center;
        }

        .delete {
            background-color: #D2042D;
            color: white;
            padding: 10px 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .table-image {
            height: 80px;
            width: 60px;
        }

        .confirmation {
            margin-left: 20%;
        }
        a{
            text-decoration:none
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <img src="<?php echo $customerProfileImage; ?>" class="profile-image">
        <div class="profile-details">
            <h2><?php echo $customerName; ?></h2>
            <form action="updateCustomer.php" method="post">
    <input type="hidden" name="customer_id" value="<?php echo $customerId; ?>">
    <button type="submit" class="hire-button">Edit Profile</button>
    <a href="index.php" class="hire-button">Back To Home</a>
</form>

        </div>
    </div>
    <div class="hiring">
    <div class="confirmation">
    <div class="confirmation">
            <h2 style="margin-left:10%;">Your Helpers</h2>
    </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Salary</th>
                    <th>Button</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $hireResult->fetch_assoc()) : ?>
                    <tr>
                        <td><img src="images/<?php echo $row['profile_image']; ?>" alt="" class="table-image"></td>
                        <td><a href="maidProfile.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
                        <td><?php echo $row['salary']; ?></td>
                        <td><a href="delete.php?maid_id=<?php echo $row['id']; ?>" class="delete">Delete</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <div class="confirmation">
        <?php
            $query = "SELECT maid_id FROM hire WHERE customer_id = '$customerId'";
            $result = $conn->query($query);

            $hireData = array();

            if ($hireResult->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $hireData[] = $row;
                }
            }

            $totalMonthlyCost = 0;

            foreach ($hireData as $hire) {
                $maidId = $hire['maid_id'];
                $query = "SELECT salary FROM helpers WHERE id = '$maidId'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $salary = $row['salary'];
                    $totalMonthlyCost += $salary;
                }
            }

            $conn->close();
        ?>

        <div class="confirmation">
            <h2>Your Total Monthly Cost is TAKA <?php echo $totalMonthlyCost; ?></h2>
        </div>
    </div>
</body>
</html>
