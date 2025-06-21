<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['roli'] !== 'prind') {
    header("Location: ../signin.php");
    exit();
}
$emri = $_SESSION['emri'];
$mbiemri = $_SESSION['mbiemri'];

require_once '../includes/db.php';
$db = $conn;


$prindi_id = $_SESSION['user_id'];

$sql = "SELECT klasa_id, mesuesi_id FROM nxenesit WHERE prindi_id = '$prindi_id' LIMIT 1";
$result = $db->query($sql);

$njoftimet = [];

if ($result && $result->num_rows > 0) {
    $data = $result->fetch_assoc();
    $mesuesi_id = $data['mesuesi_id'];

    $query = "
        SELECT n.titulli, n.pershkrimi, n.data, u.emri, u.mbiemri, u.roli
        FROM njoftimet n
        JOIN users u ON n.autori_id = u.id
        WHERE u.roli = 'drejtor' OR n.autori_id = '$mesuesi_id'
        ORDER BY n.data DESC
    ";
    $result_njoftime = $db->query($query);
    if ($result_njoftime) {
        while ($row = $result_njoftime->fetch_assoc()) {
            $njoftimet[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EduNotes | Njoftimet</title>

  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
    }

    .notices-wrapper {
      padding: 30px;
      background-color: #f9f9f9;
      margin: 20px;
      max-height: 500px;
      overflow-y: auto;
      border-radius: 10px;
    }

    .notices-header h2 {
      margin-bottom: 20px;
      font-size: 22px;
      color: #375E7A;
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
      word-break: break-word;
    }

    .notice h3 {
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 8px;
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
      color: #375E7A;
    }

    /* Scroll bar design opsional */
    .notices-wrapper::-webkit-scrollbar {
      width: 6px;
    }

    .notices-wrapper::-webkit-scrollbar-thumb {
      background-color: rgba(55, 94, 122, 0.4);
      border-radius: 10px;
    }

    @media (max-width: 768px) {
      .notices {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>
  <div class="dashboard-container">
    <div class="dashboard-sidebar">
      <div class="user-info">
        <img src="../img/logo.png" alt="User" />
        <p><?= $emri . ' ' . $mbiemri ?><br><small>Prind</small></p>
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
      <a href="parent_announcements.php" class="nav-link">
        <img src="../img/njoftime.png" class="nav-icon" alt="Njoftimet" />
        <span>Njoftimet</span>
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
        </div>

        <div class="notices">
          <?php if (!empty($njoftimet)): ?>
            <?php foreach ($njoftimet as $n): ?>
              <div class="notice">
                <h3><?= htmlspecialchars($n['titulli']) ?></h3>
                <p class="notice-date"><strong>Data:</strong> <?= $n['data'] ?></p>
                <p><?= nl2br(htmlspecialchars($n['pershkrimi'])) ?></p>
                <p class="notice-author"><strong>Autor:</strong> <?= $n['emri'] . ' ' . $n['mbiemri'] ?> (<?= $n['roli'] ?>)</p>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p style="padding: 10px;">Nuk ka njoftime për momentin.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
