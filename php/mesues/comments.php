<?php
session_start();
require_once '../includes/db.php';

$mesuesi_id = $_SESSION['user_id'];

$user_query = $conn->query("SELECT emri, mbiemri FROM users WHERE id = $mesuesi_id");
$user = $user_query->fetch_assoc();
$emri = $user['emri'];
$mbiemri = $user['mbiemri'];

$mesuesi_id = $_SESSION['user_id'];

// Merr nxënësit
$nxenesit = $conn->query("SELECT id, emri, mbiemri FROM nxenesit WHERE mesuesi_id = $mesuesi_id");

// Merr lëndët
$lendet = $conn->query("SELECT id, emri FROM lendet");

// Merr komentet
$komentet = $conn->query("
  SELECT k.*, n.emri AS emri_nx, n.mbiemri AS mbiemri_nx, l.emri AS lenda_emri
  FROM komentet k
  JOIN nxenesit n ON k.nxenesi_id = n.id
  LEFT JOIN lendet l ON k.lenda_id = l.id
  WHERE k.mesuesi_id = $mesuesi_id
  ORDER BY k.id DESC
");
?>
<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8" />
  <title>Komentet</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .scroll-table { max-height: 400px; overflow-y: auto; margin: 20px; border: 1px solid #ccc; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 8px; border: 1px solid #ccc; }
    .modal-comments {
      position: fixed;
      z-index: 1000;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background-color: rgba(0, 0, 0, 0.4);
    }
    .modal-content-comments {
        background-color: white;
        padding: 20px;
        width: 40%;
        border-radius: 8px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .close-comments {
      float: right;
      font-size: 24px;
      cursor: pointer;
    }
    .modal-comments input,
.modal-comments select,
.modal-comments textarea {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  box-sizing: border-box;
}

.modal-comments textarea {
  resize: vertical;
  min-height: 80px;
}

.modal-comments label {
  font-weight: 500;
  margin-top: 10px;
  display: block;
}
.user-info p{
  margin-bottom:20px;
  margin-top:25px;
  font-size: 16px;
  font-family: 'Poppins', sans-serif;
}
  </style>
</head>
<body>
<div class="dashboard-container">

  <!-- Sidebar -->
  <div class="dashboard-sidebar">
        <div class="user-info">
          <img src="../img/logo.png" alt="User">
          <p><?php echo $emri . ' ' . $mbiemri; ?><br><small>Mësues</small></p>
        </div>
      
        <a href="dashboard.php" class="nav-link ">
            <img src="../img/panelikryesor.png" class="nav-icon" alt="Paneli" />
            <span>Paneli kryesor</span>
        </a>
        
        <a href="grades.php" class="nav-link ">
            <img src="../img/vendosnota.png" class="nav-icon" alt="Vendos Nota" />
            <span>Vendos Nota</span>
        </a>
        
        <a href="comments.php" class="nav-link">
            <img src="../img/komentet.png" class="nav-icon" alt="Komentet" />
            <span>Komentet</span>
        </a>
        
        <a href="announcements.php" class="nav-link ">
            <img src="../img/njoftime.png" class="nav-icon" alt="Njoftime" />
            <span>Njoftime</span>
        </a>
    </div>

  <!-- Main -->
  <div class="dashboard-main">
    <div class="dashboard-topbar">
      <h2>EduNotes</h2>
      <div><span>Përshendetje <?= $emri ?>!</span><a href="../logout.php">⇦ Dil</a></div>
    </div>

    <button onclick="openCommentModal()" style="margin:20px;">Shto Koment</button>

    <!-- Modal -->
    <div id="modal-comments" class="modal-comments" style="display: none;">
      <div class="modal-content-comments">
        <span class="close-comments" onclick="closeCommentModal()">&times;</span>
        <h2>Shto Koment për Nxënësin</h2>
        <form id="commentForm">
          <label>Nxënësi:</label>
          <select name="nxenesi_id" id="nxenesi_id">
            <?php while($r = $nxenesit->fetch_assoc()): ?>
              <option value="<?= $r['id'] ?>"><?= $r['emri'] . ' ' . $r['mbiemri'] ?></option>
            <?php endwhile; ?>
          </select>

          <label>Lloji i Komentit:</label>
          <select name="lloji_komentit" id="lloji" onchange="toggleLendaDropdown()">
            <option value="Përgjithshëm">Përgjithshëm</option>
            <option value="Sipas lëndës">Sipas lëndës</option>
          </select>

          <div id="lendaDropdown" style="display: none;">
            <label>Lënda:</label>
            <select name="lenda_id">
              <option value="">-- Zgjedh lëndën --</option>
              <?php mysqli_data_seek($lendet, 0); while($l = $lendet->fetch_assoc()): ?>
                <option value="<?= $l['id'] ?>"><?= $l['emri'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <label>Përshkrimi:</label>
          <textarea name="pershkrimi" rows="4" required></textarea>

          <button type="submit" class="submit-btn">Ruaj Komentin</button>
        </form>
      </div>
    </div>

    <!-- Tabela -->
    <h3 style="margin-left:20px;">Komentet e vendosura</h3>
    <div class="scroll-table">
      <table>
        <thead>
          <tr>
            <th>Nxënësi</th>
            <th>Lloji</th>
            <th>Lënda</th>
            <th>Përshkrimi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($k = $komentet->fetch_assoc()): ?>
            <tr>
              <td><?= $k['emri_nx'] . ' ' . $k['mbiemri_nx'] ?></td>
              <td><?= $k['lloji_komentit'] ?></td>
              <td><?= $k['lenda_emri'] ?? '-' ?></td>
              <td><?= $k['pershkrimi'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

<!-- JavaScript -->
<script>
function openCommentModal() {
  document.getElementById("modal-comments").style.display = "block";
}

function closeCommentModal() {
  document.getElementById("modal-comments").style.display = "none";
}

function toggleLendaDropdown() {
  const lloji = document.getElementById("lloji").value;
  const dropdown = document.getElementById("lendaDropdown");
  dropdown.style.display = lloji === "Sipas lëndës" ? "block" : "none";
}

document.getElementById("commentForm").addEventListener("submit", function(e) {
  e.preventDefault();
  const formData = new URLSearchParams(new FormData(this));
  fetch('comments_insert.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: formData
  })
  .then(res => res.text())
  .then(msg => {
    alert(msg.trim());
    closeCommentModal();
    location.reload();
  });
});
</script>
</body>
</html>
