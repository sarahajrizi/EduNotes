<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['roli'] !== 'mesues') {
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
  <title>EduNotes Njoftime - Mësues</title>

  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

  <style>
    
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
    }

    .notices-wrapper {
      padding: 30px;
      background-color: #f9f9f9;
      border-radius: 10px;
      margin: 20px;
      max-height: 500px;
      overflow-y: auto;
    }

    .notices-header {
      display: block;
      margin-bottom: 20px;
    }

    .notices-header h2 {
      margin-bottom: 10px;
    }

    #teacherNewNoticeBtn {
      padding: 8px 16px;
      background-color: #375E7A;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .notices {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
    }

    .notice {
      background-color: white;
      border: 1px solid #ccc;
      border-left: 4px solid #375E7A;
      border-radius: 6px;
      padding: 15px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .notice h3 {
      font-size: 16px;
      font-weight: 600;
      margin: 0 0 5px 0;
      color: #1f1f1f;
    }

    .notice p {
      font-size: 13px;
      margin: 6px 0;
      line-height: 1.5;
    }

    .notice .notice-date {
      font-size: 12px;
      color: #777;
    }

    .notice .notice-author {
      font-weight: 500;
      margin-top: 10px;
      font-size: 13px;
      color: #222;
    }

    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }

    .modal-content {
      background-color: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      width: 400px;
      max-width: 90%;
      position: relative;
    }

    #closeModalBtn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 20px;
      font-weight: bold;
      cursor: pointer;
    }

    .hidden {
      display: none;
    }

    input, textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    button[type="submit"] {
      background-color: #375E7A;
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: 500;
    }
  </style>
</head>

<body>
  <div class="dashboard-container">
    <div class="dashboard-sidebar">
      <div class="user-info">
        <img src="../img/logo.png" alt="User" />
        <p><?= $emri . ' ' . $mbiemri ?><br><small>Mësues</small></p>
      </div>

      <a href="dashboard.php" class="nav-link">
        <img src="../img/panelikryesor.png" class="nav-icon" alt="Paneli" />
        <span>Paneli kryesor</span>
      </a>
      <a href="grades.php" class="nav-link">
        <img src="../img/vendosnota.png" class="nav-icon" alt="Vendos Nota" />
        <span>Vendos Nota</span>
      </a>
      <a href="comments.php" class="nav-link">
        <img src="../img/komentet.png" class="nav-icon" alt="Komentet" />
        <span>Komentet</span>
      </a>
      <a href="announcements.php" class="nav-link">
        <img src="../img/njoftime.png" class="nav-icon" alt="Njoftime" />
        <span>Njoftime</span>
      </a>
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
          <button id="teacherNewNoticeBtn">Krijo një njoftim të ri <span style="font-weight: bold;">+</span></button>
        </div>

        <div class="notices" id="teacherNoticesContainer">
          <!-- Njoftimet do të ngarkohen me JavaScript ose PHP -->
        </div>
      </div>
    </div>
  </div>

  <div id="teacherNoticeFormModal" class="modal hidden">
    <div class="modal-content">
      <span id="closeModalBtn">&times;</span>
      <h3>Krijo një njoftim të ri</h3>
      <form id="teacherNoticeForm">
        <label for="titleTeacher">Titulli</label>
        <input type="text" name="titleTeacher" id="titleTeacher" required />

        <label for="descriptionTeacher">Përshkrimi</label>
        <textarea name="descriptionTeacher" id="descriptionTeacher" required></textarea>

        <label for="dateTeacher">Data</label>
        <input type="date" name="dateTeacher" id="dateTeacher" required />

        <label for="authorTeacher">Autori</label>
        <input type="text" name="authorTeacher" id="authorTeacher" value="<?= $emri . ' ' . $mbiemri ?>" required />

        <button type="submit">Dërgo Njoftimin</button>
      </form>
    </div>
  </div>

  <script src="../js/script.js"></script>
  <script>
    document.getElementById("closeModalBtn").addEventListener("click", function () {
      document.getElementById("teacherNoticeFormModal").classList.add("hidden");
    });
  </script>
</body>
</html>
