<?php
session_start();
include("connect.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="homepage.css">
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

    <div class="banner">
        <div class="content">
            <h1>
            Hello  <?php 
            if(isset($_SESSION['email'])){
            $email=$_SESSION['email'];
            $query=mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.email='$email'");
            while($row=mysqli_fetch_array($query)){
            echo $row['firstName'].' '.$row['lastName'];
        }
        }
        ?>
        :)
        </h1>
        <p>Selamat datang ke Sistem Kehadiran Solat Subuh Aspura KVSEP.</p>
        <p>Halaman ini dicipta oleh Khairul dan Idzhar dari 2 DVM ISK</p>
        </div>
    </div>

</body>
</html>

