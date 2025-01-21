<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_db"; // Change this to match your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an action is set for API functionality
$action = $_GET['action'] ?? null;

if ($action === 'getStudents_A2') {
    // API: Fetch all student data
    header('Content-Type: application/json');
    $query = "SELECT * FROM students_a2";
    $result = $conn->query($query);

    $students_a2 = [];
    while ($row = $result->fetch_assoc()) {
        $students_a2[] = $row;
    }

    echo json_encode($students_a2);
    exit(); // Exit after sending JSON response
}

if ($action === 'getAttendance_A2') {
    // API: Fetch all attendance records
    header('Content-Type: application/json');
    $query = "SELECT * FROM attendance_a2";
    $result = $conn->query($query);

    $attendance_a2 = [];
    while ($row = $result->fetch_assoc()) {
        $attendance_a2[] = $row;
    }

    echo json_encode($attendance_a2);
    exit(); // Exit after sending JSON response
}

// Default behavior: Render HTML page

// Fetch attendance data
$attendance_a2Query = "SELECT * FROM attendance_a2";
$attendance_a2Result = $conn->query($attendance_a2Query);

// Calculate total unique students from attendance
$totalStudents_A2Query = "SELECT COUNT(DISTINCT fingerprint_id) AS total_students_a2 FROM attendance_a2";
$totalStudents_A2Result = $conn->query($totalStudents_A2Query);
$totalStudents_A2 = 0;

if ($totalStudents_A2Result && $totalStudents_A2Result->num_rows > 0) {
    $row = $totalStudents_A2Result->fetch_assoc();
    $totalStudents_A2 = $row['total_students_a2'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kehadiran Fingerprint - Dorm A2</title>
    <link rel="stylesheet" href="Student.css">
    <script src="A2.js" defer></script>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="LOGO.png" alt="Logo">
        </div>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="Dorm.php">Attendance</a></li>
            <li><a href="LogoutPage.php">Log Out</a></li>
        </ul>
    </nav>

    <h1>Attendance Tracking System - Dorm A2</h1>

    <section id="students_a2-section">
        <h2>Maklumat Pelajar</h2>
        <table id="studentsa2-Table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Dorm</th>
                    <th>Fingerprint ID</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded here dynamically -->
            </tbody>
        </table>
    </section>

    <section id="attendance_a2-section">
        <h2>Rekod Kehadiran</h2>
        <table id="attendancea2-Table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fingerprint ID</th>
                    <th>Tarikh & Masa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($attendance_a2Result && $attendance_a2Result->num_rows > 0) {
                    while ($row = $attendance_a2Result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['fingerprint_id'] . "</td>";
                        echo "<td>" . $row['timestamp'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No attendance records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <p><strong>Total Students:</strong> <?php echo $totalStudents_A2; ?></p>
    </section>
    
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
