<?php
include_once "../includes/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulli = $_POST['titleTeacher'];
    $pershkrimi = $_POST['descriptionTeacher'];
    $data = $_POST['dateTeacher'];

    if (!isset($_SESSION['user_id'])) {
        echo "Jo i kyçur";
        exit;
    }

    $autori_id = $_SESSION['user_id'];

    $sql = "INSERT INTO njoftimet (titulli, pershkrimi, data, autori_id)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $titulli, $pershkrimi, $data, $autori_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Gabim gjatë shtimit";
    }

    $stmt->close();
    $conn->close();
}
?>
