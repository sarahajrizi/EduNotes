<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Sesioni ka skaduar. Ju lutem kyçuni përsëri.";
    exit;
}

$mesuesi_id = $_SESSION['user_id'];

$nxenesi_id = $_POST['nxenesi_id'] ?? null;
$lloji = $_POST['lloji_komentit'] ?? null;
$lenda_id = $_POST['lenda_id'] ?? null;
$pershkrimi = $_POST['pershkrimi'] ?? null;

if (!$nxenesi_id || !$lloji || !$pershkrimi) {
    echo "Të gjitha fushat e kërkuara duhet të plotësohen.";
    exit;
}

if ($lloji === "Përgjithshëm") {
    $lenda_id = null;
}

$stmt = $conn->prepare("INSERT INTO komentet (nxenesi_id, mesuesi_id, lloji_komentit, lenda_id, pershkrimi) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisss", $nxenesi_id, $mesuesi_id, $lloji, $lenda_id, $pershkrimi);

if ($stmt->execute()) {
    echo "Koment u ruajt me sukses!";
} else {
    echo "Gabim gjatë ruajtjes: " . $stmt->error;
}
?>
