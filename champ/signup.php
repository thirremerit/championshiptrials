<?php
include "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = ($_POST['role'] === 'worker') ? 'worker' : 'citizen';

    $sql = "INSERT INTO users (username, email, password, role) 
            VALUES ('$username', '$email', '$password', '$role')";

    if ($conn->query($sql)) {
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header("Location: index.php");
        exit;
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>
        <img src="photos/Hipster_Walking/Hipster_Walking_1.png" alt="Mascot" id="mascot">
        CityCare
    </h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
    </nav>
</header>

<div class="container">
    <h2>Sign Up</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>Role:</label>
        <select name="role" required>
            <option value="citizen" selected>Citizen</option>
            <option value="worker">Government Worker</option>
        </select>

        <button type="submit">Sign Up</button>
    </form>
</div>

<footer>
    &copy; 2025 CityCare
</footer>

<script>
const mascot = document.getElementById('mascot');
const frames = [
    'photos/Hipster_Walking/Hipster_Walking_1.png',
    'photos/Hipster_Walking/Hipster_Walking_2.png',
    'photos/Hipster_Walking/Hipster_Walking_3.png',
    'photos/Hipster_Walking/Hipster_Walking_4.png'
];
let currentFrame = 0;
setInterval(() => {
    currentFrame = (currentFrame + 1) % frames.length;
    mascot.src = frames[currentFrame];
}, 200);
</script>

</body>
</html>
