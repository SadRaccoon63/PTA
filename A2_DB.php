<?php
include 'connect.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? null;

if ($action === 'getStudents') {
    // Dapatkan semua data pelajar
    $query = "SELECT * FROM students";
    $result = $conn->query($query);

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    echo json_encode($students);
}

if ($action === 'getAttendance') {
    // Dapatkan semua rekod kehadiran
    $query = "SELECT * FROM attendance";
    $result = $conn->query($query);

    $attendance = [];
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }

    echo json_encode($attendance);
}
?>
