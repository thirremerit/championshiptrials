<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report an Issue</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>CityCare</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="issues.php">View Issues</a>
        <a href="logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a>
    </nav>
</header>

<div class="container">
    <h2>Report an Issue</h2>
    <form action="submit_report.php" method="POST" enctype="multipart/form-data">
        <label>Title:</label>
        <input type="text" name="title" placeholder="Enter issue title" required>

        <label>Description:</label>
        <textarea name="description" placeholder="Describe the issue" required></textarea>

        <label>Category:</label>
        <select name="category" required>
            <option>Pothole</option>
            <option>Broken Light</option>
            <option>Trash</option>
            <option>Road Damage</option>
            <option>Other</option>
        </select>

        <label>Location:</label>
        <input type="text" name="location" placeholder="Enter location" required>

        <label>Photo (optional):</label>
        <input type="file" name="photo">

        <button type="submit">Submit Issue</button>
    </form>
</div>

<footer>
    &copy; 2025 CityCare
</footer>

</body>
</html>
