<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['roli'] !== 'drejtor') {
    header("Location: ../signin.php");
    exit();
}
$emri = $_SESSION['emri'];
$mbiemri = $_SESSION['mbiemri'];

require_once '../includes/db.php';

 
$klasat = [];
$sql_klasat = "SELECT id, emri, paralelja, mesuesi_id FROM klasat";
$result_klasat = $conn->query($sql_klasat);
if ($result_klasat->num_rows > 0) {
    while ($row = $result_klasat->fetch_assoc()) {
        $klasat[] = $row;
    }
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['shto-nxenes'])) {
    $emri = $_POST['emri'];
    $mbiemri = $_POST['mbiemri'];
    $klasa_id = $_POST['klasa_id'];
    $emri_prind = $_POST['emri_prind'];
    $mbiemri_prind = $_POST['mbiemri_prind'];
    $email_prind = $_POST['email_prind'];
    $fjalkalimi_prind = $_POST['fjalkalimi'];
 
    $sql_mesuesi = "SELECT mesuesi_id FROM klasat WHERE id = ?";
    $stmt_mesuesi = $conn->prepare($sql_mesuesi);
    $stmt_mesuesi->bind_param("i", $klasa_id);
    $stmt_mesuesi->execute();
    $result_mesuesi = $stmt_mesuesi->get_result();
 
    if ($result_mesuesi->num_rows > 0) {
        $row = $result_mesuesi->fetch_assoc();
        $mesuesi_id = $row['mesuesi_id'];
 
        $stmt_nxenes = $conn->prepare("INSERT INTO nxenesit (emri, mbiemri, klasa_id, mesuesi_id) VALUES (?, ?, ?, ?)");
        $stmt_nxenes->bind_param("ssii", $emri, $mbiemri, $klasa_id, $mesuesi_id);
 
        if ($stmt_nxenes->execute()) {
            $nxenes_id = $conn->insert_id;
 
            $stmt_prind = $conn->prepare("INSERT INTO users (emri, mbiemri, email, fjalkalimi, roli) VALUES (?, ?, ?, ?, 'prind')");
            $stmt_prind->bind_param("ssss", $emri_prind, $mbiemri_prind, $email_prind, $fjalkalimi_prind);
 
            if ($stmt_prind->execute()) {
                $prindi_id = $conn->insert_id;
 
                $stmt_update_nxenes = $conn->prepare("UPDATE nxenesit SET prindi_id = ? WHERE id = ?");
                $stmt_update_nxenes->bind_param("ii", $prindi_id, $nxenes_id);
 
                if ($stmt_update_nxenes->execute()) {
                    echo "✅ Nxënësi dhe prindi u regjistruan me sukses!";
                } else {
                    echo "❌ Gabim në lidhjen e nxënësit me prindin: " . $conn->error;
                }
            } else {
                echo "❌ Gabim në regjistrimin e prindit: " . $conn->error;
            }
        } else {
            echo "❌ Gabim në regjistrimin e nxënësit: " . $conn->error;
        }
    } else {
        echo "❌ Nuk u gjet mësuesi për këtë klasë.";
    }
}
?>
 
 
 
<!DOCTYPE html>
<html lang="sq">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <title>Menaxho Nxënësit</title>
</head>
<body>
<div class="dashboard-container">
        <div class="dashboard-sidebar">
            <div class="user-info">
                <img src="../img/logo.png" alt="User">
                <p><?= $emri . ' ' . $mbiemri ?><br><small>Drejtor</small></p>
            </div>
 
            <a href="dashboard.php" class="nav-link">
                <img src="../img/panelikryesor.png" class="nav-icon" alt="Paneli" />
                <span>Paneli kryesor</span>
            </a>
 
            <a href="manage-teachers.php" class="nav-link">
                <img src="../img/menaxhomesuesit.png" class="nav-icon" alt="Menaxho Mësuesit" />
                <span>Menaxho Mësuesit</span>
            </a>
 
            <a href="manage-students.php" class="nav-link">
                <img src="../img/Menaxho Nxënësit.png" class="nav-icon" alt="Menaxho Nxënësit" />
                <span>Menaxho Nxënësit</span>
            </a>
 
            <a href="director-class&subjects.php" class="nav-link">
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
                   <span>Përshëndetje <?= $emri ?>!</span>
                    <a href="../logout.php">⇦ Dil</a>
                </div>
            </div>


      <div class="manage-students-box">
      <div class="title-and-button">
        <h3>Menaxho Nxënësit</h3>
        <button class="shto-nxenes-btn" id="addStudentBtn">
          <i class="fa fa-user-plus"></i> Shto Nxënës
        </button>
      </div>
   <form method="GET" action="manage-students.php">
  <div class="filter">
    <select id="klasa" name="klasa">
        <option value="" disabled selected>Zgjidh Klasa</option> 
        <?php
        $sql_klasa = "SELECT DISTINCT emri FROM klasat";
        $result_klasa = $conn->query($sql_klasa);
 
        if ($result_klasa && $result_klasa->num_rows > 0) {
            while ($row_klasa = $result_klasa->fetch_assoc()) {
                echo "<option value='{$row_klasa['emri']}'>{$row_klasa['emri']}</option>";
            }
        }
        ?>
    </select>
 
    <select id="paralelja" name="paralelja">
        <option value="" disabled selected>Zgjidh Paralelen</option>
        <?php
        $sql_paralelja = "SELECT DISTINCT paralelja FROM klasat";
        $result_paralelja = $conn->query($sql_paralelja);
 
        if ($result_paralelja && $result_paralelja->num_rows > 0) {
            while ($row_paralelja = $result_paralelja->fetch_assoc()) {
                echo "<option value='{$row_paralelja['paralelja']}'>{$row_paralelja['paralelja']}</option>";
            }
        }
        ?>
    </select>
      <button type="submit">Filtro</button>
 
</div>
 
</form>
 
 
 
      <div class="nxenesit">
  <table border="1" cellpadding="8">
    <thead>
      <tr>
        <th>Emri</th>
        <th>Mbiemri</th>
        <th>Klasa</th>
        <th>Paralelja</th>
        <th>Prindi</th>
        <th>Mësuesi</th>
      </tr>
    </thead>
    <tbody>
    <?php
$klasa = isset($_GET['klasa']) ? $_GET['klasa'] : '';
$paralelja = isset($_GET['paralelja']) ? $_GET['paralelja'] : '';
 
$sql = "SELECT nxenesit.emri, nxenesit.mbiemri, klasat.emri AS klasa_emri, klasat.paralelja, 
        prindi.emri AS prindi_emri, prindi.mbiemri AS prindi_mbiemri,
        mesuesi.emri AS mesuesi_emri, mesuesi.mbiemri AS mesuesi_mbiemri
        FROM nxenesit
        JOIN klasat ON nxenesit.klasa_id = klasat.id
        LEFT JOIN users AS prindi ON nxenesit.prindi_id = prindi.id
        LEFT JOIN users AS mesuesi ON nxenesit.mesuesi_id = mesuesi.id";
 
if (!empty($klasa)) {
    $sql .= " WHERE klasat.emri = '$klasa'";
}
 
if (!empty($paralelja)) {
    $sql .= !empty($klasa) ? " AND klasat.paralelja = '$paralelja'" : " WHERE klasat.paralelja = '$paralelja'";
}
 
$result = $conn->query($sql);
 
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['emri']}</td>
                <td>{$row['mbiemri']}</td>
                <td>{$row['klasa_emri']}</td>
                <td>{$row['paralelja']}</td>
                <td>{$row['prindi_emri']} {$row['prindi_mbiemri']}</td>
                <td>{$row['mesuesi_emri']} {$row['mesuesi_mbiemri']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>Nuk ka nxënës për këtë filtrim.</td></tr>";
}
?>
 
    </tbody>
  </table>
</div>
 
      <div id="addStudentModal" class="modal2">
        <div class="modal-content2">
          <span class="close2">&times;</span>
          <h2>Shto Nxënës</h2>
          <form action="" method="POST" class="add-student-form">
    <div class="form-container">
        <div class="left-column">
            <h3>Informacionet për Nxënësin</h3>
            <label for="emri">Emri i Nxënësit:</label>
            <input type="text" name="emri" id="emri" required>
 
            <label for="mbiemri">Mbiemri i Nxënësit:</label>
            <input type="text" name="mbiemri" id="mbiemri" required>
 
            <label for="klasa_id">Zgjedh klasën:</label>
<select name="klasa_id" id="klasa_id" required>
    <option value="">-- Zgjedh klasën --</option>
    <?php foreach ($klasat as $klasa): ?>
        <option value="<?= $klasa['id'] ?>"><?= $klasa['emri'] . ' / ' . $klasa['paralelja'] ?></option>
    <?php endforeach; ?>
</select>
 
 
 
 
        </div>
 
        <div class="right-column">
            <h3>Informacionet për Prindin</h3>
            <label for="emri_prind">Emri i Prindit:</label>
            <input type="text" name="emri_prind" id="emri_prind" required>
 
            <label for="mbiemri_prind">Mbiemri i Prindit:</label>
            <input type="text" name="mbiemri_prind" id="mbiemri_prind" required>
 
            <label for="email_prind">Email i Prindit:</label>
            <input type="email" name="email_prind" id="email_prind" required>
 
            <label for="fjalkalimi_prind">Fjalkalimi i Prindit:</label>
            <input type="password" name="fjalkalimi" id="fjalkalimi" required>
 
        </div>
    </div>
    <button type="submit" name="shto-nxenes">Shto Nxënës</button>
</form>
 
 
        </div>
      </div>
    </div>
    </div> 
  </div>
 
  <script>
    const modal2 = document.getElementById("addStudentModal");
const btn = document.getElementById("addStudentBtn");
const closeBtn = document.getElementsByClassName("close2")[0]; 
 
btn.onclick = function () {
  modal2.style.display = "block";
}
 
closeBtn.onclick = function () {
  modal2.style.display = "none";
}
 
window.onclick = function (event) {
  if (event.target == modal2) {
    modal2.style.display = "none";
  }
}
 
  </script>
 
  <style>
    .modal2 {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.4);
}
 
.modal-content2 {
  background-color: #fefefe;
  margin: 2% auto;     
  padding: 15px;
  border: 1px solid #888;
  width: 30%;       
}
 
.close2 {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}
 
.close2:hover,
.close2:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.add-student-form {
    display: block;
    margin: 20px auto;
    width: 80%;
    max-width: 1200px;
}
 
.form-container {
    display: flex;
    justify-content: space-between;
    gap: 40px;
}
 
.left-column {
    width: 48%; 
}
 
.right-column {
    width: 48%;
}
 
label {
    display: block;
    margin-top: 10px;
}
 
input, select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
 
.shto-nxenes {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    margin-top: 20px;
}
 
.shto-nxenes:hover {
    background-color: #45a049;
}
.nxenesit {
  max-width: 100%; 
    overflow-x: auto;
    overflow-y: auto;
    height: 350px; 
    margin: 20px 30px;
  }
 
  table {
    width: 100%; 
    border-collapse: collapse; 
    table-layout: fixed; 
 
  }
 
  th, td {
    padding: 5px;
    text-align: left;
    border: 1px solid #ddd; 
  }
 
  th {
    background-color: #f2f2f2;
  }
 
  tr:nth-child(even) {
    background-color: #f9f9f9; 
  }
 
  tr:hover {
    background-color: #f1f1f1; 
  }
 
.filter {
    display: flex; 
    align-items: center; 
    gap: 20px;  
    margin-left: 40px;  
}
 
#klasa, #paralelja {
    width: 200px; 
    padding: 6px 15px;
    border: 1px solid #375E7A;
    border-radius: 5px;
    background-color: #375E7A;
    font-size: 14px;
    color: white;
}
 
#klasa option:disabled, #paralelja option:disabled {
    color: #888; 
    background-color: #e0e0e0;
}
 
#klasa:hover, #paralelja:hover {
    border-color: #375E7A;
}
 
#klasa:focus, #paralelja:focus {
    border-color: #375E7A;
    outline: none;
}
 
label {
    font-size: 16px;
    color: #333;
}
 
button[type="submit"] {
    padding: 6px 15px;
    background-color: #375E7A;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top:-6px;
}
 
button[type="submit"]:hover {
    background-color: #2c4a67;
}
.manage-students-box{
    background-color: #f9f9f9; margin: auto; padding: 15px; border-radius: 12px; margin-top: 20px;
    max-width: 1350px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
  
</style>
</body>
</html>3