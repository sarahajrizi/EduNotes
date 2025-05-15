<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['roli'] !== 'drejtor') {
    header("Location: ../signin.php");
    exit();
}

$emri = $_SESSION['emri'];
$mbiemri = $_SESSION['mbiemri'];

// përfshi lidhjen me databazën
include_once "../includes/db.php";

// Merr numrat nga databaza
$result_nxenes = $conn->query("SELECT COUNT(*) AS total FROM nxenesit");
$row_nxenes = $result_nxenes->fetch_assoc();
$nr_nxenes = $row_nxenes['total'];

$result_mesues = $conn->query("SELECT COUNT(*) AS total FROM users WHERE roli = 'mesues'");
$row_mesues = $result_mesues->fetch_assoc();
$nr_mesues = $row_mesues['total'];

$result_klasa = $conn->query("SELECT COUNT(*) AS total FROM klasat");
$row_klasa = $result_klasa->fetch_assoc();
$nr_klasa = $row_klasa['total'];

$result_perdorues = $conn->query("SELECT COUNT(*) AS total FROM users");
$row_perdorues = $result_perdorues->fetch_assoc();
$nr_perdorues = $row_perdorues['total'];
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduNotes - Drejtori</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">

        <div class="dashboard-sidebar">
            <div class="user-info">
              <img src="../img/logo.png" alt="User">
              <p><?php echo $emri . ' ' . $mbiemri; ?><br><small>Drejtor</small></p>
            </div>
          
            <a href="#" class="nav-link">
                <img src="../img/panelikryesor.png" class="nav-icon" alt="Paneli" />
                <span>Paneli kryesor</span>
            </a>
            
            <a href="manage-teachers.php" class="nav-link">
                <img src="../img/menaxhomesuesit.png" class="nav-icon" alt="Menaxho Mësuesit" />
                <span>Menaxho Mësuesit</span>
            </a>
            
            <a href="#" class="nav-link">
                <img src="../img/Menaxho Nxënësit.png" class="nav-icon" alt="Menaxho Nxënësit" />
                <span>Menaxho Nxënësit</span>
            </a>
            
            <a href="#" class="nav-link">
                <img src="../img/klasatdhelendet.png" class="nav-icon" alt="Klasat dhe Lëndët" />
                <span>Klasat dhe Lëndët</span>
            </a>

            <a href="director-announcements.php" class="nav-link">
                <img src="../img/njoftime.png" class="nav-icon" alt="Njoftime" />
                <span>Njoftime</span>
            </a>
        </div>

        <div class="dashboard-main">
            <div class="dashboard-topbar">
              <h2>EduNotes</h2>
              <div>
                <span>Përshëndetje  <?php echo $emri; ?>!</span>
                <a href="../logout.php">⇦ Dil</a>
              </div>
            </div>

            <div class="dashboard-content">
                <div class="cards">
                  <div class="card">
                    <img src="../img/students.png" alt="" width="40" height="40">
                    <div>
                      <h3><?php echo $nr_nxenes; ?></h3>
                      <p>Nxënës</p>
                    </div>
                  </div>
                  <div class="card">
                    <img src="../img/teachers.png" alt="" width="30" height="30">
                    <div>
                      <h3><?php echo $nr_mesues; ?></h3>
                      <p>Mësues</p>
                    </div>
                  </div>
                  <div class="card active">
                    <img src="../img/classrooms.png" alt="" width="40" height="40">
                    <div>
                      <h3><?php echo $nr_klasa; ?></h3>
                      <p>Klasa</p>
                    </div>
                  </div>
                  <div class="card">
                    <img src="../img/users.png" alt="" width="40" height="30">
                    <div>
                      <h3><?php echo $nr_perdorues; ?></h3>
                      <p>Përdorues</p>
                    </div>
                  </div>
                </div>
              
                <div class="dashboard-bottom">
                  <div class="chart">
                    <h4>Statistikat e Notave</h4>
                    <img src="../img/statistika.png" alt="Grafiku i notave" />
                  </div>
              
                  <div class="notifications">
                    <h4>Njoftime e fundit</h4>
                    <ul>
                      <li>Pushim për nder të Fitër Bajramit</li>
                      <li>Pushimi pranveror fillon nga data 05.04.2025</li>
                      <li>Mbledhje me mësues më 10.05.2025</li>
                    </ul>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <?php $conn->close(); ?>
</body>
</html>
