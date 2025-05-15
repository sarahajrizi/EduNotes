<?php 
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['roli'] !== 'mesues') {
    header("Location: ../signin.php");
    exit();
}

$emri = $_SESSION['emri'];
$mbiemri = $_SESSION['mbiemri'];
$mesues_id = $_SESSION['user_id'];

include_once "../includes/db.php";

// Merr klasën dhe paralelen e mësuesit
$query_klasa = $conn->query("SELECT emri, paralelja FROM klasat WHERE mesuesi_id = $mesues_id LIMIT 1");
$klasa_info = $query_klasa->fetch_assoc();
$klasa_emri = $klasa_info['emri'] ?? '---';
$paralelja = $klasa_info['paralelja'] ?? '---';

// Numri i nxënësve të këtij mësuesi
$query_nxenes = $conn->query("SELECT COUNT(*) AS total FROM nxenesit WHERE mesuesi_id = $mesues_id");
$nr_nxenes = $query_nxenes->fetch_assoc()['total'] ?? 0;

// Nota të paplotësuara (kur nota1 ose nota2 janë NULL)
$query_notat = $conn->query("
    SELECT COUNT(*) AS total FROM notat 
    WHERE nxenesi_id IN (
        SELECT id FROM nxenesit WHERE mesuesi_id = $mesues_id
    ) AND (nota1 IS NULL OR nota2 IS NULL)
");
$nr_notapaplot = $query_notat->fetch_assoc()['total'] ?? 0;

// Komente të pashkruara (teksti NULL ose bosh)
$query_komentet = $conn->query("
    SELECT COUNT(*) AS total FROM komentet 
    WHERE nxenesi_id IN (
        SELECT id FROM nxenesit WHERE mesuesi_id = $mesues_id
    ) AND (pershkrimi IS NULL OR pershkrimi = '')
");
$nr_komentepa = $query_komentet->fetch_assoc()['total'] ?? 0;

// Njoftimet nga drejtori ose që i ka krijuar vetë mësuesi
$query_njoftime = $conn->query("
    SELECT titulli FROM njoftimet 
    WHERE autori_id = $mesues_id 
    OR autori_id IN (SELECT id FROM users WHERE roli = 'drejtor')
    ORDER BY data DESC
    LIMIT 5
");

$njoftimeList = [];
while ($r = $query_njoftime->fetch_assoc()) {
    $njoftimeList[] = $r['titulli'];
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduNotes Dashboard - Mësuesi</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<div class="dashboard-container">

    <div class="dashboard-sidebar">
        <div class="user-info">
          <img src="../img/logo.png" alt="User">
          <p><?php echo $emri . ' ' . $mbiemri; ?><br><small>Mësues</small></p>
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
            <span>Përshëndetje <?php echo $emri; ?>!</span>
            <a href="../logout.php">⇦ Dil</a>
          </div>
        </div>
      
        <div class="dashboard-cards">
          <div class="dashboard-card full-width">
            <div class="dashboard-title">Të dhënat kryesore</div>
            <div class="profile-info">
              <img src="../img/teacher.png" alt="Teacher">
              <div class="profile-info-text">
                Mësuesi: <?php echo $emri . ' ' . $mbiemri; ?><br>
                Klasa: <?php echo htmlspecialchars($klasa_emri); ?><br>
                Paralelja: <?php echo htmlspecialchars($paralelja); ?>
              </div>
            </div>
          </div>
        
          <div class="dashboard-card-row">
            <div class="dashboard-card">
              <div class="dashboard-title">Statistika</div>
              <div class="stats-list">
                <img src="../img/student.png" class="icon"/><span>Gjithësej nxënës:</span>
                <span class="number"><?php echo $nr_nxenes; ?></span><br>
                <img src="../img/pencil.png" class="icon"/><span>Nota të paplotësuara: </span>
                <span class="number"><?php echo $nr_notapaplot; ?></span><br>
                <img src="../img/comment.png" class="icon"/><span>Komente të pashkruara: </span>
                <span class="number"><?php echo $nr_komentepa; ?></span><br>
              </div>
            </div>
        
            <div class="dashboard-card">
              <div class="dashboard-title">Njoftime</div>
              <ul class="notifications-list">
                <?php if (empty($njoftimeList)): ?>
                  <li>Nuk ka njoftime për të shfaqur.</li>
                <?php else: ?>
                  <?php foreach ($njoftimeList as $njoftim): ?>
                    <li><?= htmlspecialchars($njoftim) ?></li>
                  <?php endforeach; ?>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
        
    </div>          
</div>
</body>
</html>
