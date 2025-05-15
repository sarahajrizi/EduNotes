<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../signin.php");
    exit;
}

$prindi_id = $_SESSION['user_id'];

// Merr të dhënat e prindit
$user_query = $conn->query("SELECT emri, mbiemri FROM users WHERE id = $prindi_id");
$prindi = $user_query->fetch_assoc();
$prindi_emri = $prindi['emri'];
$prindi_mbiemri = $prindi['mbiemri'];

// Merr fëmijët e këtij prindi
$nxenesit = $conn->query("SELECT id, emri, mbiemri FROM nxenesit WHERE prindi_id = $prindi_id");

$femijet = [];
while ($r = $nxenesit->fetch_assoc()) {
    $femijet[] = $r;
}

$selected_nxenesi_id = $_GET['nxenesi_id'] ?? ($femijet[0]['id'] ?? null);

$notat = [];
if ($selected_nxenesi_id) {
    $query = "
        SELECT l.emri AS lenda, n.nota1, n.nota2, n.nota_perfundimtare
        FROM notat n
        JOIN lendet l ON l.id = n.lenda_id
        WHERE n.nxenesi_id = $selected_nxenesi_id
    ";
    $result = $conn->query($query);
    while ($r = $result->fetch_assoc()) {
        $notat[] = $r;
    }

    // merr emrin e nxënësit
    $selected_emri = "";
    foreach ($femijet as $f) {
        if ($f['id'] == $selected_nxenesi_id) {
            $selected_emri = $f['emri'] . ' ' . $f['mbiemri'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8" />
  <title>EduNotes Notat</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
<div class="dashboard-container">
  <!-- Sidebar -->
  <div class="dashboard-sidebar">
    <div class="user-info">
      <img src="../img/logo.png" alt="User">
      <p><?= $prindi_emri . ' ' . $prindi_mbiemri ?><br><small>Prind</small></p>
    </div>
    <a href="dashboard.php" class="nav-link">
      <img src="../img/panelikryesor.png" class="nav-icon" alt="Paneli" />
      <span>Paneli kryesor</span>
    </a>
    <a href="grades.php" class="nav-link">
      <img src="../img/vendosnota.png" class="nav-icon" alt="Notat" />
      <span>Notat</span>
    </a>
    <a href="comments.php" class="nav-link">
      <img src="../img/komentet.png" class="nav-icon" alt="Komentet" />
      <span>Komentet</span>
    </a>
    <a href="announcements.php" class="nav-link">
      <img src="../img/njoftime.png" class="nav-icon" alt="Njoftime" />
      <span>Njoftimet</span>
    </a>
  </div>

  <!-- Main -->
  <div class="dashboard-main">
    <div class="dashboard-topbar">
      <h2>EduNotes</h2>
      <div>
        <span>Përshendetje z. <?= $prindi_emri ?>!</span>
        <a href="../logout.php">⇦ Dil</a>
      </div>
    </div>

    <?php if (count($femijet) > 1): ?>
    <div class="student-dropdown" style="margin: 20px;">
      <form method="GET">
        <select name="nxenesi_id" onchange="this.form.submit()">
          <?php foreach ($femijet as $f): ?>
            <option value="<?= $f['id'] ?>" <?= $f['id'] == $selected_nxenesi_id ? 'selected' : '' ?>>
              <?= $f['emri'] . ' ' . $f['mbiemri'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </form>
    </div>
    <?php else: ?>
      <h3 style="margin-left: 20px;">Notat për: <?= $selected_emri ?></h3>
    <?php endif; ?>

    <div style="margin: 20px;">
      <table style="width: 100%; border-collapse: collapse;">
        <thead>
          <tr style="background-color: #f2f2f2;">
            <th style="padding: 10px; border: 1px solid #ccc;">Lënda</th>
            <th style="padding: 10px; border: 1px solid #ccc;">Nota 1</th>
            <th style="padding: 10px; border: 1px solid #ccc;">Nota 2</th>
            <th style="padding: 10px; border: 1px solid #ccc;">Nota Përfundimtare</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($notat as $n): ?>
            <tr>
              <td style="padding: 10px; border: 1px solid #ccc;"><?= $n['lenda'] ?></td>
              <td style="padding: 10px; border: 1px solid #ccc;"><?= $n['nota1'] ?? '-' ?></td>
              <td style="padding: 10px; border: 1px solid #ccc;"><?= $n['nota2'] ?? '-' ?></td>
              <td style="padding: 10px; border: 1px solid #ccc;"><?= $n['nota_perfundimtare'] ?? '-' ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
