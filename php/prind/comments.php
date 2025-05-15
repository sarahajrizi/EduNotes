<?php
session_start();
require_once '../includes/db.php';

$prind_id = $_SESSION['user_id'] ?? null;

// Merr të dhënat për prindin e kyçur dhe fëmijët e tij
$nxenesit = $conn->query("SELECT id, emri, mbiemri FROM nxenesit WHERE prindi_id = $prind_id");
$nxenesList = [];
while ($r = $nxenesit->fetch_assoc()) {
  $nxenesList[] = $r;
}

// Merr lëndët
$lendet = $conn->query("SELECT id, emri FROM lendet");
$lendetList = [];
while ($l = $lendet->fetch_assoc()) {
  $lendetList[] = $l;
}

$komentet = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nxenesi_id = $_POST['nxenesi_id'] ?? ($nxenesList[0]['id'] ?? null);
  $lloji = $_POST['lloji_komentit'] ?? null;
  $lenda_id = $_POST['lenda_id'] ?? null;

  $query = "
    SELECT k.*, n.emri AS emri_nx, n.mbiemri AS mbiemri_nx, l.emri AS lenda_emri
    FROM komentet k
    JOIN nxenesit n ON k.nxenesi_id = n.id
    LEFT JOIN lendet l ON k.lenda_id = l.id
    WHERE k.nxenesi_id = $nxenesi_id
  ";
  if ($lloji === 'Përgjithshëm') {
    $query .= " AND k.lloji_komentit = 'Përgjithshëm'";
  } elseif ($lloji === 'Sipas lëndës' && $lenda_id) {
    $query .= " AND k.lloji_komentit = 'Sipas lëndës' AND k.lenda_id = $lenda_id";
  }
  $query .= " ORDER BY k.id DESC";
  $komentet = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <title>Komentet - Prindi</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
  .filter-bar {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
    gap: 15px;
    margin: 20px 20px 0;
    flex-wrap: wrap;
  }

  .filter-bar select,
  .filter-bar button {
    padding: 10px 20px;
    border: none;
    border-radius: 12px;
    background-color: #335774;
    color: white;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 14px;
    cursor: pointer;
    transition: 0.3s ease;
    width: 240px;
    height: 44px;
    box-sizing: border-box;
  }

  .filter-bar button {
    text-align: center;
    margin-top: 5px;
  }

  .filter-bar select:hover,
  .filter-bar button:hover {
    background-color: #27465e;
  }

  .comments-table {
    margin: 20px;
    width: calc(100% - 40px);
    border-collapse: collapse;
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
  }

  .comments-table th, .comments-table td {
    border: 1px solid #eee;
    padding: 12px 16px;
    text-align: left;
  }

  .comments-table th {
    background-color: #f0f4f8;
    font-weight: 600;
  }

  .comments-table tr:nth-child(even) {
    background-color: #fafafa;
  }
</style>

  <script>
    function toggleLendaDropdown() {
      const lloji = document.getElementById("lloji").value;
      document.getElementById("lendaDropdown").style.display = (lloji === "Sipas lëndës") ? "block" : "none";
    }
  </script>
</head>
<body>
  <div class="dashboard-container">
    <div class="dashboard-sidebar">
      <div class="user-info">
        <img src="../img/logo.png" alt="User">
        <p><?= $_SESSION['emri'] . ' ' . $_SESSION['mbiemri'] ?><br><small>Prind</small></p>
      </div>
      <a href="dashboard.php" class="nav-link">
        <img src="../img/panelikryesor.png" class="nav-icon"> <span>Paneli kryesor</span>
      </a>
      <a href="grades.php" class="nav-link">
        <img src="../img/vendosnota.png" class="nav-icon"> <span>Notat</span>
      </a>
      <a href="comments.php" class="nav-link">
        <img src="../img/komentet.png" class="nav-icon"> <span>Komentet</span>
      </a>
      <a href="announcements.php" class="nav-link">
        <img src="../img/njoftime.png" class="nav-icon"> <span>Njoftimet</span>
      </a>
    </div>
    <div class="dashboard-main">
      <div class="dashboard-topbar">
        <h2>EduNotes</h2>
        <div>
          <span>Përshendetje <?= $_SESSION['emri'] ?>!</span>
          <a href="../logout.php">⇦ Dil</a>
        </div>
      </div>

      <form method="POST" class="filter-bar">
        <?php if (count($nxenesList) > 1): ?>
        <select name="nxenesi_id">
          <option value="">Zgjidh fëmijën</option>
          <?php foreach ($nxenesList as $nx): ?>
            <option value="<?= $nx['id'] ?>"><?= $nx['emri'] . ' ' . $nx['mbiemri'] ?></option>
          <?php endforeach; ?>
        </select>
        <?php else: ?>
          <input type="hidden" name="nxenesi_id" value="<?= $nxenesList[0]['id'] ?>">
        <?php endif; ?>

        <select name="lloji_komentit" id="lloji" onchange="toggleLendaDropdown()">
          <option value="">Zgjidh llojin</option>
          <option value="Përgjithshëm">Përgjithshëm</option>
          <option value="Sipas lëndës">Sipas lëndës</option>
        </select>

        <select name="lenda_id" id="lendaDropdown" style="display:none;">
          <option value="">Zgjidh lëndën</option>
          <?php foreach ($lendetList as $l): ?>
            <option value="<?= $l['id'] ?>"><?= $l['emri'] ?></option>
          <?php endforeach; ?>
        </select>

        <button type="submit" class="btn-primary">Shfaq</button>
      </form>

      <table class="comments-table">
        <thead>
          <tr>
            <th>Emri i Nxënësit</th>
            <th>Komenti</th>
            <th>Lloji i Komentit</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($komentet) && $komentet->num_rows > 0): ?>
            <?php while($row = $komentet->fetch_assoc()): ?>
              <tr>
                <td><?= $row['emri_nx'] . ' ' . $row['mbiemri_nx'] ?></td>
                <td><?= $row['pershkrimi'] ?></td>
                <td><?= $row['lloji_komentit'] === 'Sipas lëndës' ? $row['lenda_emri'] : 'I përgjithshëm' ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="3">Nuk ka komente për të shfaqur.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>

    </div>
  </div>
</body>
</html>
