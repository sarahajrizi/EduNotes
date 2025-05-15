<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../signin.php");
    exit;
}
require_once '../includes/db.php';

$mesuesi_id = $_SESSION['user_id'];

$user_query = $conn->query("SELECT emri, mbiemri FROM users WHERE id = $mesuesi_id");
$user = $user_query->fetch_assoc();
$emri = $user['emri'];
$mbiemri = $user['mbiemri'];


$mesuesi_id = $_SESSION['user_id'];
require_once '../includes/db.php';

// Merr nxënësit që i takojnë këtij mësuesi
$nxenesit_result = $conn->query("SELECT id, emri, mbiemri FROM nxenesit WHERE mesuesi_id = $mesuesi_id");

// Merr lëndët
$lendet_result = $conn->query("SELECT id, emri FROM lendet");

// Merr notat për tabelën
$query = "
  SELECT 
    n.emri AS emri_nx, 
    n.mbiemri AS mbiemri_nx, 
    l.emri AS lenda, 
    no.periudha, 
    no.nota1, 
    no.nota2, 
    no.nota_perfundimtare
  FROM notat no
  JOIN nxenesit n ON no.nxenesi_id = n.id
  JOIN lendet l ON no.lenda_id = l.id
  WHERE n.mesuesi_id = $mesuesi_id
  ORDER BY no.id DESC
";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduNotes Vendos nota</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
  <div class="dashboard-container">
    <div class="dashboard-sidebar">
      <div class="user-info">
        <img src="../img/logo.png" alt="User">
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
        <span>Përshendetje  <?= $emri ?>!</span>
          <a href="../logout.php">⇦ Dil</a>
        </div>
      </div>

      <button onclick="openGradeModal()" style="margin: 20px; padding: 10px 20px;">Shto Notë</button>

      <div id="modal-grades" class="modal-grades">
        <div class="modal-content-grades">
          <span class="close-grades" onclick="closeGradeModal()">&times;</span>
          <h2>Shto Notë për Nxënësin</h2>
          <form>
            <label for="nxenesi">Nxënësi:</label>
            <select id="nxenesi" name="nxenesi">
              <?php while($row = $nxenesit_result->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['emri'] . ' ' . $row['mbiemri'] ?></option>
              <?php endwhile; ?>
            </select>

            <label for="lenda">Lënda:</label>
            <select id="lenda" name="lenda">
              <?php while($row = $lendet_result->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['emri'] ?></option>
              <?php endwhile; ?>
            </select>

            <label for="periudha">Periudha:</label>
            <select id="periudha" name="periudha">
              <option value="Periudha 1">Periudha 1</option>
              <option value="Periudha 2">Periudha 2</option>
            </select>

            <label for="nota1">Nota 1:</label>
            <input type="number" id="nota1" name="nota1" min="1" max="5">

            <label for="nota2">Nota 2:</label>
            <input type="number" id="nota2" name="nota2" min="1" max="5">

            <label for="nota_p">Nota Përfundimtare:</label>
            <input type="number" id="nota_p" name="nota_p" min="1" max="5">

            <button type="button" id="submitGradesBtn" class="submit-btn" onclick="submitGrades()">Ruaj Notën</button>
          </form>
        </div>
      </div>

      <h3 style="margin-left: 20px;">Notat e vendosura</h3>
      <div style="max-height: 400px; overflow-y: auto; margin: 20px; border: 1px solid #ccc;">
        <table style="border-collapse: collapse; width: 100%;">
          <thead>
            <tr style="background-color: #f2f2f2;">
              <th style="border: 1px solid #ccc; padding: 8px;">Nxënësi</th>
              <th style="border: 1px solid #ccc; padding: 8px;">Lënda</th>
              <th style="border: 1px solid #ccc; padding: 8px;">Periudha</th>
              <th style="border: 1px solid #ccc; padding: 8px;">Nota 1</th>
              <th style="border: 1px solid #ccc; padding: 8px;">Nota 2</th>
              <th style="border: 1px solid #ccc; padding: 8px;">Nota Përfundimtare</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
              <tr>
                <td style="border: 1px solid #ccc; padding: 8px;"><?= $row['emri_nx'] . ' ' . $row['mbiemri_nx'] ?></td>
                <td style="border: 1px solid #ccc; padding: 8px;"><?= $row['lenda'] ?></td>
                <td style="border: 1px solid #ccc; padding: 8px;"><?= $row['periudha'] ?></td>
                <td style="border: 1px solid #ccc; padding: 8px;"><?= $row['nota1'] ?></td>
                <td style="border: 1px solid #ccc; padding: 8px;"><?= $row['nota2'] ?></td>
                <td style="border: 1px solid #ccc; padding: 8px;"><?= $row['nota_perfundimtare'] ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>

  <script>
    function openGradeModal() {
      document.getElementById("modal-grades").style.display = "block";
    }

    function closeGradeModal() {
      document.getElementById("modal-grades").style.display = "none";
    }

    window.onclick = function(event) {
      const modal = document.getElementById("modal-grades");
      if (event.target === modal) {
        closeGradeModal();
      }
    }

    function submitGrades() {
      const data = {
        nxenesi: document.getElementById("nxenesi").value,
        lenda: document.getElementById("lenda").value,
        periudha: document.getElementById("periudha").value,
        nota1: document.getElementById("nota1").value,
        nota2: document.getElementById("nota2").value,
        nota_p: document.getElementById("nota_p").value
      };

      fetch('grades_insert.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(data)
      })
      .then(response => response.text())
      .then(result => {
        if (result.trim() === "Sukses") {
          alert("Nota u ruajt me sukses!");
          closeGradeModal();
          location.reload(); // rifresko faqen për të përditësuar tabelën
        } else {
          alert("Gabim gjatë ruajtjes: " + result);
        }
      });
    }
  </script>
</body>
</html>
