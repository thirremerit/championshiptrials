<?php
session_start();
include 'db_connect.php'; // your database connection file

// Get filter values from URL
$search   = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$location = $_GET['location'] ?? '';
$status   = $_GET['status'] ?? '';

// Build query dynamically
$query = "SELECT * FROM issues WHERE 1=1";

if($search) {
    $query .= " AND (title LIKE '%$search%' OR description LIKE '%$search%')";
}
if($category) {
    $query .= " AND category='$category'";
}
if($location) {
    $query .= " AND location LIKE '%$location%'";
}
if($status) {
    $query .= " AND status='$status'";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>CityCare - Issues</title>
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
        <a href="report.php">Report Issue</a>
        <a href="issues.php">View Issues</a>
    </nav>
</header>

<div class="container">
    <h2>Reported Issues</h2>

    <!-- Search / Filter Form -->
    <form method="GET" action="issues.php" class="filter-form">
        <input type="text" name="search" placeholder="Search keyword..." value="<?php echo htmlspecialchars($search); ?>">
        <select name="category">
            <option value="">All Categories</option>
            <option value="Pothole" <?php if($category=='Pothole') echo 'selected'; ?>>Pothole</option>
            <option value="Trash" <?php if($category=='Trash') echo 'selected'; ?>>Trash</option>
            <option value="Broken Light" <?php if($category=='Broken Light') echo 'selected'; ?>>Broken Light</option>
        </select>
        <input type="text" name="location" placeholder="Location..." value="<?php echo htmlspecialchars($location); ?>">
        <select name="status">
            <option value="">All Statuses</option>
            <option value="Pending" <?php if($status=='Pending') echo 'selected'; ?>>Pending</option>
            <option value="In Progress" <?php if($status=='In Progress') echo 'selected'; ?>>In Progress</option>
            <option value="Resolved" <?php if($status=='Resolved') echo 'selected'; ?>>Resolved</option>
        </select>
        <button type="submit">Filter</button>
    </form>

    <!-- Issues Table -->
    <table>
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Location</th>
            <th>Status</th>
            <th>Reported By</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): 
            $statusVal = $row['status'] ?? 'Unknown';
            $class = '';
            if($statusVal == 'Pending') $class = 'status-pending';
            elseif($statusVal == 'In Progress') $class = 'status-inprogress';
            elseif($statusVal == 'Resolved') $class = 'status-resolved';
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['category']); ?></td>
            <td><?php echo htmlspecialchars($row['location']); ?></td>
            
            <td>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'worker'): ?>
                <form method="POST" action="update_status.php">
                    <input type="hidden" name="issue_id" value="<?php echo $row['id']; ?>">
                    <select name="status" class="<?php echo $class; ?>" onchange="this.form.submit()">
                        <option value="Pending" <?php if($statusVal=='Pending') echo 'selected'; ?>>Pending</option>
                        <option value="In Progress" <?php if($statusVal=='In Progress') echo 'selected'; ?>>In Progress</option>
                        <option value="Resolved" <?php if($statusVal=='Resolved') echo 'selected'; ?>>Resolved</option>
                    </select>
                </form>
            <?php else: ?>
                <span class="<?php echo $class; ?>"><?php echo htmlspecialchars($statusVal); ?></span>
            <?php endif; ?>
            </td>

            <td><?php echo !empty($row['reported_by']) ? htmlspecialchars($row['reported_by']) : 'Unknown'; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<footer>
    &copy; 2025 CityCare
</footer>

<!-- Mascot Animation Script -->
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
