<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_db"; // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an action is set for API functionality
$action = $_GET['action'] ?? null;

if ($action === 'getStudents_A3') {
    // API: Fetch all student data
    header('Content-Type: application/json');
    $query = "SELECT * FROM students_a3";
    $result = $conn->query($query);

    $students_a3 = [];
    while ($row = $result->fetch_assoc()) {
        $students_a3[] = $row;
    }

    echo json_encode($students_a3);
    exit();
}

if ($action === 'getAttendance_A3') {
    // API: Fetch all attendance records
    header('Content-Type: application/json');
    $query = "SELECT * FROM attendance_a3";
    $result = $conn->query($query);

    $attendance_a3 = [];
    while ($row = $result->fetch_assoc()) {
        $attendance_a3[] = $row;
    }

    echo json_encode($attendance_a3);
    exit();
}

// Fetch attendance data
$attendance_a3Query = "SELECT * FROM attendance_a3";
$attendance_a3Result = $conn->query($attendance_a3Query);

// Calculate total unique students
$totalStudents_A3Query = "SELECT COUNT(DISTINCT fingerprint_id) AS total_students_a3 FROM attendance_a3";
$totalStudents_A3Result = $conn->query($totalStudents_A3Query);
$totalStudents_A3 = 0;

if ($totalStudents_A3Result && $totalStudents_A3Result->num_rows > 0) {
    $row = $totalStudents_A3Result->fetch_assoc();
    $totalStudents_A3 = $row['total_students_a3'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kehadiran Fingerprint - Dorm A3</title>
    <link rel="stylesheet" href="Student.css">
    <script src="A3.js" defer></script>
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

    <h1>Attendance Tracking System - Dorm A3</h1>

    <section id="students_a3-section">
        <h2>Maklumat Pelajar</h2>
        <table id="studentsa3-Table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Dorm</th>
                    <th>Fingerprint ID</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded dynamically -->
            </tbody>
        </table>
    </section>

    <section id="attendance_a3-section">
        <h2>Rekod Kehadiran</h2>
        <table id="attendancea3-Table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fingerprint ID</th>
                    <th>Tarikh & Masa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($attendance_a3Result && $attendance_a3Result->num_rows > 0) {
                    while ($row = $attendance_a3Result->fetch_assoc()) {
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
        <p><strong>Total Students:</strong> <?php echo $totalStudents_A3; ?></p>
    </section>
</body>
</html>
<?php
$conn->close();
?>
