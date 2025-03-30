<?php
session_start();
$conn = new mysqli("localhost", "admin", "admin123", "testdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$query = "SELECT * FROM products WHERE owner_id = $user_id";
$result = $conn->query($query);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM products WHERE name LIKE '%$search%' AND owner_id = $user_id";
    $result = $conn->query($query);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: white;
            margin: 5px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        }
        a {
            display: block;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>Bienvenido, <?php echo $username; ?></h2>
    <form method="POST">
        <input type="text" name="search" placeholder="Buscar productos">
        <button type="submit">Buscar</button>
    </form>
    <ul>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <li><?php echo $row['name'] . " - " . $row['price']; ?></li>
        <?php } ?>
    </ul>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
