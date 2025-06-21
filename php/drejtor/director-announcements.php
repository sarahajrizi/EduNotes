<?php
include('../includes/db.php');
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['roli'] !== 'drejtor') {
    header("Location: ../signin.php");
    exit();
}

$emri = $_SESSION['emri'];
$mbiemri = $_SESSION['mbiemri'];
?>

<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduNotes Njoftime</title>

  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/drejtor.css" />
</head>

<body>
  <div class="dashboard-container">
    <div class="dashboard-sidebar">
      <div class="user-info">
        <img src="../img/logo.png" alt="User" />
        <p><?= $emri . ' ' . $mbiemri; ?><br><small>Drejtor</small></p>
      </div>
      <a href="dashboard.php" class="nav-link"><img src="../img/panelikryesor.png" class="nav-icon" alt="" /> <span>Paneli kryesor</span></a>
      <a href="manage-teachers.php" class="nav-link"><img src="../img/menaxhomesuesit.png" class="nav-icon" alt="" /> <span>Menaxho Mësuesit</span></a>
      <a href="manage-students.php" class="nav-link"><img src="../img/Menaxho Nxënësit.png" class="nav-icon" alt="" /> <span>Menaxho Nxënësit</span></a>
      <a href="director-class&subjects.php" class="nav-link"><img src="../img/klasatdhelendet.png" class="nav-icon" alt="" /> <span>Klasat dhe Lëndët</span></a>
      <a href="director-announcements.php" class="nav-link"><img src="../img/njoftime.png" class="nav-icon" alt="" /> <span>Njoftime</span></a>
    </div>

    <div class="dashboard-main">
      <div class="dashboard-topbar">
        <h2>EduNotes</h2>
        <div>
          <span>Përshëndetje <?= $emri ?>!</span>
          <a href="../logout.php">⇦ Dil</a>
        </div>
      </div>

      <div class="notices-wrapper">
        <div class="notices-header">
          <h2>Njoftimet</h2>
          <button id="newNoticeBtn">Krijo një njoftim të ri <span style="font-weight: bold;">+</span></button>
        </div>

        <div class="notices" id="noticesContainer">
          <!-- Njoftimet do të ngarkohen me JavaScript -->
        </div>
      </div>
    </div>
  </div>

  <div id="noticeFormModal" class="modal hidden">
    <div class="modal-content">
      <span id="closeModalBtn">&times;</span>
      <h3>Krijo një njoftim të ri</h3>
      <form id="noticeForm">
        <label for="title">Titulli</label>
        <input type="text" name="title" id="title" required />

        <label for="description">Përshkrimi</label>
        <textarea name="description" id="description" required></textarea>

        <label for="date">Data</label>
        <input type="date" name="date" id="date" required />

        <label for="author">Autori</label>
        <input type="text" name="author" id="author" value="<?= $emri . ' ' . $mbiemri ?>" required />

        <button type="submit">Dërgo Njoftimin</button>
      </form>
    </div>
  </div>

  <script src="../js/script.js"></script>
  <script>
    document.getElementById("closeModalBtn").addEventListener("click", function () {
      document.getElementById("noticeFormModal").classList.add("hidden");
    });
  </script>
</body>
</html>
