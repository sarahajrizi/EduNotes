<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['roli'] !== 'drejtor') {
    header("Location: ../signin.php");
    exit();
}

$emri = $_SESSION['emri'];
$mbiemri = $_SESSION['mbiemri'];

include('../includes/db.php');

if (isset($_GET['fshij'])) {
    $id = intval($_GET['fshij']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND roli = 'mesues'");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    header("Location: manage-teachers.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['shto_mesues'])) {
    $emri = htmlspecialchars($_POST['emri']);
    $mbiemri = htmlspecialchars($_POST['mbiemri']);
    $email = htmlspecialchars($_POST['email']);
    $fjalkalimi = $_POST['fjalkalimi'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $stmt = $conn->prepare("INSERT INTO users (emri, mbiemri, email, fjalkalimi, roli) VALUES (?, ?, ?, ?, 'mesues')");
        $stmt->bind_param("ssss", $emri, $mbiemri, $email, $fjalkalimi);
        $stmt->execute();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['perditeso_mesues'])) {
    $id = $_POST['id'];
    $emri = htmlspecialchars($_POST['emri']);
    $mbiemri = htmlspecialchars($_POST['mbiemri']);
    $email = htmlspecialchars($_POST['email']);

    $stmt = $conn->prepare("UPDATE users SET emri=?, mbiemri=?, email=? WHERE id=? AND roli='mesues'");
    $stmt->bind_param("sssi", $emri, $mbiemri, $email, $id);
    $stmt->execute();
    header("Location: manage-teachers.php");
    exit();
}

$mesuesit = $conn->query("SELECT * FROM users WHERE roli = 'mesues'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menaxho Mësuesit</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/drejtor.css">

</head>
<body>
<div class="dashboard-container">
  <div class="dashboard-sidebar">
    <div class="user-info">
      <img src="../img/logo.png" alt="User">
      <p><?= $emri . ' ' . $mbiemri ?><br><small>Drejtor</small></p>
    </div>
    <a href="dashboard.php" class="nav-link"><img src="../img/panelikryesor.png" class="nav-icon"> Paneli kryesor</a>
    <a href="manage-teachers.php" class="nav-link"><img src="../img/menaxhomesuesit.png" class="nav-icon"> Menaxho Mësuesit</a>
    <a href="manage-students.php" class="nav-link"><img src="../img/Menaxho Nxënësit.png" class="nav-icon"> Menaxho Nxënësit</a>
    <a href="director-class&subjects.php" class="nav-link"><img src="../img/klasatdhelendet.png" class="nav-icon"> Klasat dhe Lëndët</a>
    <a href="director-announcements.php" class="nav-link"><img src="../img/njoftime.png" class="nav-icon"> Njoftime</a>
  </div>
  <div class="dashboard-main">
    <div class="dashboard-topbar">
      <h2>EduNotes</h2>
      <div>
        <span>Përshëndetje <?= $emri ?>!</span>
        <a href="../logout.php">⇦ Dil</a>
      </div>
    </div>
    <div class="teacher-management">
      <h3>Menaxho Mësuesit</h3>
      <button class="add-button" onclick="showAddModal()">Shto mësues</button>
      <div class="teachers-table-container">
        <table class="teachers-table">
          <thead><tr><th>Emri</th><th>Email</th><th>Veprime</th></tr></thead>
          <tbody>
            <?php while ($r = $mesuesit->fetch_assoc()): ?>
              <tr>
                <td><?= $r['emri'] . ' ' . $r['mbiemri'] ?></td>
                <td><?= $r['email'] ?></td>
                <td>
                  <a class="edit" href="#" onclick='editMesues(<?= json_encode($r) ?>)'>Edito</a>
                  <a class="delete" href="?fshij=<?= $r['id'] ?>" onclick="return confirm('A jeni i sigurt që doni ta fshini?')">Fshije</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modals -->
<div id="addTeacherModal" class="modal1">
  <div class="modal-content1">
    <span class="close1" onclick="closeModal('addTeacherModal')">&times;</span>
    <h3>Shto Mësues</h3>
    <form method="POST">
      <input type="text" name="emri" placeholder="Emri" required>
      <input type="text" name="mbiemri" placeholder="Mbiemri" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="fjalkalimi" placeholder="Fjalëkalimi" required>
      <button type="submit" name="shto_mesues">Shto</button>
    </form>
  </div>
</div>

<div id="editTeacherModal" class="modal1">
  <div class="modal-content1">
    <span class="close1" onclick="closeModal('editTeacherModal')">&times;</span>
    <h3>Përditëso Mësuesin</h3>
    <form method="POST">
      <input type="hidden" name="id" id="edit-id">
      <input type="text" name="emri" id="edit-emri" placeholder="Emri" required>
      <input type="text" name="mbiemri" id="edit-mbiemri" placeholder="Mbiemri" required>
      <input type="email" name="email" id="edit-email" placeholder="Email" required>
      <button type="submit" name="perditeso_mesues">Përditëso</button>
    </form>
  </div>
</div>

<script>
function showAddModal() {
  document.getElementById('addTeacherModal').style.display = 'block';
}
function closeModal(id) {
  document.getElementById(id).style.display = 'none';
}
function editMesues(m) {
  document.getElementById('edit-id').value = m.id;
  document.getElementById('edit-emri').value = m.emri;
  document.getElementById('edit-mbiemri').value = m.mbiemri;
  document.getElementById('edit-email').value = m.email;
  document.getElementById('editTeacherModal').style.display = 'block';
}
window.onclick = function(e) {
  if (e.target.classList.contains('modal1')) {
    closeModal('addTeacherModal');
    closeModal('editTeacherModal');
  }
}
</script>
</body>
</html>
