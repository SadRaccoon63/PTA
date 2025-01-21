<?php
include 'connect.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? null;

if ($action === 'getStudents_A1') {
    $query = "SELECT * FROM students_a1";
    $result = $conn->query($query);

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    echo json_encode($students);
    exit();
}

if ($action === 'getAttendance_A1') {
    $query = "SELECT * FROM attendance_a1";
    $result = $conn->query($query);

    $attendance = [];
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }

    echo json_encode($attendance);
    exit();
}
?>
