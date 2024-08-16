<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin.php");
    exit();
}

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'helping_hand';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$helpersQuery = "SELECT id, name FROM helpers";
$helpersResult = $conn->query($helpersQuery);

$customersQuery = "SELECT id, name FROM customers";
$customersResult = $conn->query($customersQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .table-container {
            display: flex;
            justify-content: space-between;
        }

        .table-container .table {
            width: 48%;
        }

        .table-container h2 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            color: #fff;
            background-color: #4caf50;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn.btn-delete {
            background-color: #f44336;
        }

        .btn.btn-edit {
            background-color: #2196f3;
        }

        .btn.btn-delete:hover,
        .btn.btn-edit:hover {
            background-color: #555;
        }

        .logout-link {
            text-align: center;
            margin-top: 20px;
        }

        .logout-link a {
            color: #4caf50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        
        <div class="table-container">
            <div class="table">
                <h2>Helpers</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($helpersResult->num_rows > 0): ?>
                            <?php while ($helperRow = $helpersResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $helperRow['id']; ?></td>
                                    <td><?php echo $helperRow['name']; ?></td>
                                    <td>
                                        <a href="delete_helper.php?id=<?php echo $helperRow['id']; ?>" class="btn btn-delete">Delete</a>
                                        <a href="edit_helper.php?id=<?php echo $helperRow['id']; ?>" class="btn btn-edit">Edit</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No helpers found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="table">
                <h2>Customers</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($customersResult->num_rows > 0): ?>
                            <?php while ($customerRow = $customersResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $customerRow['id']; ?></td>
                                    <td><?php echo $customerRow['name']; ?></td>
                                    <td>
                                        <a href="delete_customer.php?id=<?php echo $customerRow['id']; ?>" class="btn btn-delete">Delete</a>
                                        <a href="edit_customer.php?id=<?php echo $customerRow['id']; ?>" class="btn btn-edit">Edit</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No customers found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="logout-link">
            <a href="admin_logout.php">Logout</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
