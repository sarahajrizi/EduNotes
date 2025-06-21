<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['roli'] !== 'drejtor') {
    header("Location: ../signin.php");
    exit();
}
$emri = $_SESSION['emri'];
$mbiemri = $_SESSION['mbiemri'];

require_once '../includes/db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addClass'])) {
    $emri = $_POST['className'];
    $paralelja = $_POST['classParallel'];
    $mesuesi_id = $_POST['classTeacher'];
    $sql = "INSERT INTO klasat (emri, paralelja, mesuesi_id) VALUES ('$emri', '$paralelja', '$mesuesi_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Klasë u shtua me sukses!";
    } else {
        echo "Gabim: " . $sql . "<br>" . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addSubject'])) {
    $emri_lende = $_POST['subjectName'];
    $klasa_id = $_POST['subjectClass'];
    $sql = "INSERT INTO lendet (emri, klasat_aplikuara) VALUES ('$emri_lende', '$klasa_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Lëndë u shtua me sukses!";
    } else {
        echo "Gabim: " . $sql . "<br>" . $conn->error;
    }
}

$klasa_sql = "
    SELECT klasat.id, klasat.emri AS emri_klases, klasat.paralelja,
           users.emri AS emri_mesuesit, users.mbiemri AS mbiemri_mesuesit
    FROM klasat
    LEFT JOIN users ON klasat.mesuesi_id = users.id";
$klasa_result = $conn->query($klasa_sql);

$lende_sql = "SELECT * FROM lendet";
$lende_result = $conn->query($lende_sql);
?>

<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduNotes Menaxho Klasat dhe Lëndët</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

  <style>

#addClassBtn{
  margin-left: 15px;
}
#addSubjectBtn{
  margin-right: 500px;
}
.content-wrapper{
  margin-top: 20px;
  margin-left: 22px;
  max-width: 1350px;
  padding: 15px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.dashboard-content {
  padding: 20px;
}
 
.section-title {
  font-size: 24px;
  margin-bottom: 10px;
}
 
.subject-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
 
.subject-table th, .subject-table td {
  padding: 12px;
  border: 1px solid #ddd;
}
 
.subject-table th {
  background-color: #f2f2f2;
}
.content-section {
  display: flex;
  gap: 40px;
  padding: 10px;
  flex-wrap: wrap;  
}
.content-wrapper{
  padding: 10px;
}
.content-wrapper h2 {
  margin-top: 10px; 
  margin-left: 0; 
}
 
.section-header {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}
 
.btn {
  background-color: #2b5d85;
  color: white;
  padding: 8px 40px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
  text-align: left;
  margin-top: -20px;
}
 
.button-container {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap; 
}
 
.table-container {
  margin-top: 10px;
  max-height: 350px;
  overflow-y: auto; 
  border: 1px solid #ddd;
}
 
.data-table {
  width: 100%;
  border-collapse: collapse;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
 
.data-table th, .data-table td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}
 
.data-table th {
  background-color: #f2f2f2;
}
.popup {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
 
.popup-content {
  background-color: #DBE6EE;
  border-radius: 8px;
  padding: 20px;
  width: 300px;
  max-width: 90%;
  display: flex;
  flex-direction: column;
  gap: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  animation: slideIn 0.3s ease-out;
  font-weight: 500  ;
  position: relative;
 
}
.popup-content h3{
  color: #375E7A;
  font-weight: 500;
}
 
 
.popup-content input {
  padding: 5px;
  border-radius: 6px;
  border: 1px solid #ddd;
  font-size: 16px;
}
.popup-content label{
  padding: -20px;
}
 
.popup-content button {
  background-color: #2b5d85;
  color: white;
  padding: 5px 20px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  align-self: flex-start;
  transition: background-color 0.3s ease;
  margin-top: 5px;
}
 
.popup-content button:hover {
  background-color: #1d4f6b;
}
.close-btn {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 24px;
  font-weight: bold;
  color: #333;
  cursor: pointer;
}
 
.close-btn:hover {
  color: rgb(60, 123, 250);
}
  </style>
</head>
<body>
  <div class="dashboard-container">
    <div class="dashboard-sidebar">
      <div class="user-info">
        <img src="../img/logo.png" alt="Logo i EduNotes" />
        <p><?= $emri . ' ' . $mbiemri ?><br><small>Drejtor</small></p>
      </div>
      <a href="dashboard.php" class="nav-link">
        <img src="../img/panelikryesor.png" class="nav-icon" alt="Paneli kryesor" />
        <span>Paneli kryesor</span>
      </a>
      <a href="manage-teachers.php" class="nav-link">
        <img src="../img/menaxhomesuesit.png" class="nav-icon" alt="Menaxho Mësuesit" />
        <span>Menaxho Mësuesit</span>
      </a>
      <a href="manage-students.php" class="nav-link">
        <img src="../img/manage students.png" class="nav-icon" alt="Menaxho Nxënësit" />
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

      <div class="content-wrapper">
        <h2 style="margin-bottom: 30px; margin-left: 15px">Klasat dhe Lëndët</h2>
        <div class="button-container">
          <button class="btn" id="addClassBtn">Shto klasë +</button>
          <button class="btn" id="addSubjectBtn">Shto lëndë +</button>
        </div>

        <div class="content-section">
          <div style="flex: 1;">
            <div class="table-container">
              <table class="data-table" id="klasaTable">
                <thead>
                  <tr>
                    <th>Klasa</th>
                    <th>Paraleja</th>
                    <th>Mësuesi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = $klasa_result->fetch_assoc()): ?>
                  <tr>
                    <td><?= $row['emri_klases'] ?></td>
                    <td><?= $row['paralelja'] ?></td>
                    <td><?= $row['emri_mesuesit'] . ' ' . $row['mbiemri_mesuesit'] ?></td>
                  </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>

          <div style="flex: 1;">
            <div class="table-container">
              <table class="data-table" id="subjectTable">
                <thead>
                  <tr>
                    <th>Emri i Lëndës</th>
                    <th>Klasa</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($row = $lende_result->fetch_assoc()): ?>
                  <tr>
                    <td><?= $row['emri'] ?></td>
                    <td><?= $row['klasat_aplikuara'] ?></td>
                  </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Popup për shtim klase -->
  <div class="popup" id="classPopup">
    <div class="popup-content">
      <span class="close-btn" onclick="closePopup('classPopup')">&times;</span>
      <h3>Shto Klasë</h3>
      <form method="POST">
        <label for="className">Zgjidh Klasën:</label>
        <select id="className" name="className" required>
          <option value="">Zgjidh Klasën</option>
          <option value="1">Klasa 1</option>
          <option value="2">Klasa 2</option>
          <option value="3">Klasa 3</option>
          <option value="4">Klasa 4</option>
          <option value="5">Klasa 5</option>
        </select>

        <label for="classParallel">Zgjidh Paralele:</label>
        <select id="classParallel" name="classParallel" required>
          <option value="">Zgjidh Paralele</option>
          <option value="1">Paralela 1</option>
          <option value="2">Paralela 2</option>
          <option value="3">Paralela 3</option>
          <option value="4">Paralela 4</option>
          <option value="5">Paralela 5</option>
        </select>

        <label for="classTeacher">Zgjidh Mësuesin:</label>
        <select id="classTeacher" name="classTeacher" required>
  <option value="">Zgjidh Mësuesin</option>
  <?php
  $teacher_sql = "SELECT id, emri, mbiemri FROM users WHERE roli = 'mesues'";
  $teacher_result = $conn->query($teacher_sql);

  if ($teacher_result && $teacher_result->num_rows > 0) {
      while ($teacher = $teacher_result->fetch_assoc()) {
          echo "<option value='" . $teacher['id'] . "'>" . $teacher['emri'] . " " . $teacher['mbiemri'] . "</option>";
      }
  } else {
      echo "<option value=''>Asnjë mësues i regjistruar</option>";
  }
  ?>
</select>


        <button type="submit" class="add-class-btn" name="addClass" >Ruaj</button>
      </form>
    </div>
  </div>

  <!-- Popup për shtim lënde -->
  <div class="popup" id="subjectPopup">
    <div class="popup-content">
      <span class="close-btn" onclick="closePopup('subjectPopup')">&times;</span>
      <h3>Shto Lëndë</h3>
      <form method="POST">
        <label for="subjectName">Emri i Lëndës:</label>
        <input type="text" id="subjectName" name="subjectName" required />

        <label for="subjectClass">Zgjidh Klasën:</label>
        <input type="text" id="subjectClass" name="subjectClass" required />

        <button type="submit" class="subject-btn" name="addSubject">Ruaj</button>
      </form>
    </div>
  </div>

  <script>
    function openPopup(id) {
      document.getElementById(id).style.display = "flex";
      document.body.style.overflow = "hidden";
    }

    function closePopup(id) {
      document.getElementById(id).style.display = "none";
      document.body.style.overflow = "auto";
    }

    document.getElementById('addClassBtn').addEventListener('click', function () {
      openPopup('classPopup');
    });

    document.getElementById('addSubjectBtn').addEventListener('click', function () {
      openPopup('subjectPopup');
    });
  </script>
</body>
</html>
