<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an action is set for API functionality
$action = $_GET['action'] ?? null;

if ($action === 'getStudents_A1') {
    // API: Fetch all student data
    header('Content-Type: application/json');
    $query = "SELECT * FROM students_a1";
    $result = $conn->query($query);

    $students_a1 = [];
    while ($row = $result->fetch_assoc()) {
        $students_a1[] = $row;
    }

    echo json_encode($students_a1);
    exit();
}

if ($action === 'getAttendance_A1') {
    // API: Fetch all attendance records
    header('Content-Type: application/json');
    $query = "SELECT * FROM attendance_a1";
    $result = $conn->query($query);

    $attendance_a1 = [];
    while ($row = $result->fetch_assoc()) {
        $attendance_a1[] = $row;
    }

    echo json_encode($attendance_a1);
    exit();
}

// Fetch attendance data
$attendance_a1Query = "SELECT * FROM attendance_a1";
$attendance_a1Result = $conn->query($attendance_a1Query);

// Calculate total unique students
$totalStudents_A1Query = "SELECT COUNT(DISTINCT fingerprint_id) AS total_students_a1 FROM attendance_a1";
$totalStudents_A1Result = $conn->query($totalStudents_A1Query);
$totalStudents_A1 = 0;

if ($totalStudents_A1Result && $totalStudents_A1Result->num_rows > 0) {
    $row = $totalStudents_A1Result->fetch_assoc();
    $totalStudents_A1 = $row['total_students_a1'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kehadiran Fingerprint - Dorm A1</title>
    <link rel="stylesheet" href="Student.css">
    <script src="A1.js" defer></script>
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

    <h1>Attendance Tracking System - Dorm A1</h1>

    <section id="students_a1-section">
        <h2>Maklumat Pelajar</h2>
        <table id="studentsa1-Table">
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

    <section id="attendance_a1-section">
        <h2>Rekod Kehadiran</h2>
        <table id="attendancea1-Table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fingerprint ID</th>
                    <th>Tarikh & Masa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($attendance_a1Result && $attendance_a1Result->num_rows > 0) {
                    while ($row = $attendance_a1Result->fetch_assoc()) {
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
        <p><strong>Total Students:</strong> <?php echo $totalStudents_A1; ?></p>
    </section>
</body>
</html>
<?php
$conn->close();
?>
