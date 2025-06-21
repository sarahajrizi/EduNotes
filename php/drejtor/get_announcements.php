<?php
include('../includes/db.php');

// Query për të marrë njoftimet nga drejtori
$sql = "
    SELECT 
        njoftimet.id, 
        titulli, 
        pershkrimi, 
        data, 
        CONCAT(users.emri, ' ', users.mbiemri) AS autori
    FROM njoftimet
    JOIN users ON njoftimet.autori_id = users.id
    WHERE users.roli = 'drejtor'
    ORDER BY data DESC
";

$result = $conn->query($sql);
if ($result === false) {
    echo "Gabim në query: " . $conn->error;
    exit;
}

// Përpunimi i rezultateve në array
$njoftime = array();
while ($row = $result->fetch_assoc()) {
    $njoftime[] = $row;
}

// Kthe JSON si përgjigje
header('Content-Type: application/json');
echo json_encode($njoftime);

// Mbyll lidhjen
$conn->close();
?>
