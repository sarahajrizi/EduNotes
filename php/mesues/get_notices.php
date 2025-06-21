<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$mesuesi_id = $_SESSION['user_id'];

$sql = "SELECT njoftimet.*, users.emri, users.mbiemri, users.roli
        FROM njoftimet
        INNER JOIN users ON njoftimet.autori_id = users.id
        WHERE users.roli = 'drejtor' OR njoftimet.autori_id = ?
        ORDER BY data DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $mesuesi_id);
$stmt->execute();

$result = $stmt->get_result();
$njoftime = [];

while ($row = $result->fetch_assoc()) {
    $njoftime[] = $row;
}

echo json_encode($njoftime);
?>
