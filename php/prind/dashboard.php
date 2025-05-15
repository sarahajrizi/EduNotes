<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['roli'] !== 'prind') {
    header("Location: ../signin.php");
    exit();
}

$emri = $_SESSION['emri'];
$mbiemri = $_SESSION['mbiemri'];
$prindi_id = $_SESSION['user_id'];

include_once "../includes/db.php";

// Merr fëmijën dhe të dhënat e klasës
$query_femija = $conn->query("
    SELECT nx.id AS nxenesi_id, nx.emri AS emri_nx, nx.mbiemri AS mbiemri_nx,
           k.id AS klasa_id, k.emri AS klasa_emri, k.paralelja
    FROM nxenesit nx
    JOIN klasat k ON nx.klasa_id = k.id
    WHERE nx.prindi_id = $prindi_id
    LIMIT 1
");

$nxenesi_id = null;
$komentet = $nota_plot = $nota_pa = 0;
$klasa = $paralelja = '?';
$nxenesi = "Nxënësi nuk u gjet";

if ($query_femija && $query_femija->num_rows > 0) {
    $femija = $query_femija->fetch_assoc();
    $nxenesi_id = $femija['nxenesi_id'];
    $nxenesi = $femija['emri_nx'] . ' ' . $femija['mbiemri_nx'];
    $klasa = $femija['klasa_emri'];
    $paralelja = $femija['paralelja'];
    $klasa_id = $femija['klasa_id'];

    // Nota të plotësuara
    $nota_plot = $conn->query("
        SELECT COUNT(*) AS total FROM notat
        WHERE nxenesi_id = $nxenesi_id
          AND (nota1 IS NOT NULL OR nota2 IS NOT NULL OR nota_perfundimtare IS NOT NULL)
    ")->fetch_assoc()['total'] ?? 0;

    // Nota të paplotësuara
    $nota_pa = $conn->query("
        SELECT COUNT(*) AS total FROM notat
        WHERE nxenesi_id = $nxenesi_id
          AND (nota1 IS NULL OR nota2 IS NULL OR nota_perfundimtare IS NULL)
    ")->fetch_assoc()['total'] ?? 0;

    // Komente
    $komentet = $conn->query("
        SELECT COUNT(*) AS total FROM komentet
        WHERE nxenesi_id = $nxenesi_id AND pershkrimi IS NOT NULL AND pershkrimi != ''
    ")->fetch_assoc()['total'] ?? 0;

    // Merr ID-në e mësuesit për këtë klasë
    $mesuesi_id = $conn->query("SELECT mesuesi_id FROM klasat WHERE id = $klasa_id")
        ->fetch_assoc()['mesuesi_id'];

    // Merr njoftimet: nga drejtori (roli = 'drejtor') ose nga mësuesi i asaj klase
    $njoftimet = $conn->query("
        SELECT titulli FROM njoftimet
        WHERE autori_id IN (
            SELECT id FROM users WHERE roli = 'drejtor' OR id = $mesuesi_id
        )
        ORDER BY data DESC
    ");
} else {
    $njoftimet = [];
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduNotes - Paneli i Prindit</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<div class="dashboard-container">

    <div class="dashboard-sidebar">
        <div class="user-info">
          <img src="../img/logo.png" alt="User">
          <p><?= $emri . ' ' . $mbiemri ?><br><small>Prind</small></p>
        </div>

        <a href="dashboard.php" class="nav-link active">
            <img src="../img/panelikryesor.png" class="nav-icon" alt="Paneli" />
            <span>Paneli kryesor</span>
        </a>
        
        <a href="grades.php" class="nav-link">
            <img src="../img/vendosnota.png" class="nav-icon" alt="Nota" />
            <span>Notat</span>
        </a>
        
        <a href="comments.php" class="nav-link">
            <img src="../img/komentet.png" class="nav-icon" alt="Komentet" />
            <span>Komentet</span>
        </a>
        
        <a href="#" class="nav-link">
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

        <div class="dashboard-cards">
          <div class="dashboard-card full-width">
            <div class="dashboard-title">Të dhënat kryesore</div>
            <div class="profile-info">
              <img src="../img/parentprofile.png" alt="Parent">
              <div class="profile-info-text">
                Prindi: <?= $emri . ' ' . $mbiemri ?><br>
                Nxënësi: <?= $nxenesi ?><br>
                Klasa: <?= $klasa ?><br>
                Paralelja: <?= $paralelja ?>
              </div>
            </div>
          </div>

          <div class="dashboard-card-row">
            <div class="dashboard-card">
              <div class="dashboard-title">Statistika</div>
              <div class="stats-list">
                <img src="../img/pencil.png" class="icon"/><span>Nota të plotësuara:</span>
                <span class="number"><?= $nota_plot ?></span><br>
                <img src="../img/pencil.png" class="icon"/><span>Nota të paplotësuara:</span>
                <span class="number"><?= $nota_pa ?></span><br>
                <img src="../img/comment.png" class="icon"/><span>Komente:</span>
                <span class="number"><?= $komentet ?></span><br>
              </div>
            </div>

            <div class="dashboard-card">
              <div class="dashboard-title">Njoftime</div>
              <ul class="notifications-list">
                <?php if ($njoftimet && $njoftimet->num_rows > 0): ?>
                  <?php while($r = $njoftimet->fetch_assoc()): ?>
                    <li><?= htmlspecialchars($r['titulli']) ?></li>
                  <?php endwhile; ?>
                <?php else: ?>
                  <li>Nuk ka njoftime për të shfaqur.</li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
    </div>
</div>
</body>
</html>

