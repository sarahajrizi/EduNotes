<?php
require_once '../includes/db.php';

// Kontrollo lidhjen me databazën
if ($conn->connect_error) {
    die("Lidhja dështoi: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulli = $_POST['title'];
    $pershkrimi = $_POST['description'];
    $data = $_POST['date'];
    $autor_full = $_POST['author'];

    // Ndarja e emrit dhe mbiemrit nga inputi
    $autor_name = explode(" ", $autor_full);
    if (count($autor_name) < 2) {
        echo "Ju lutem, shkruani emrin dhe mbiemrin e autorit.";
        exit;
    }

    $emri_autorit = $autor_name[0];
    $mbiemri_autorit = $autor_name[1];

    // Verifikimi i plotësimit të fushave
    if (empty($titulli) || empty($pershkrimi) || empty($data) || empty($emri_autorit) || empty($mbiemri_autorit)) {
        echo "Të gjitha fushat janë të detyrueshme.";
        exit;
    }

    // Kontrollo nëse ekziston drejtori me këtë emër dhe mbiemër
    $sql_author = $conn->prepare("SELECT id FROM users WHERE emri = ? AND mbiemri = ? AND roli = 'drejtor'");
    $sql_author->bind_param("ss", $emri_autorit, $mbiemri_autorit);
    $sql_author->execute();
    $result_author = $sql_author->get_result();

    if ($result_author->num_rows > 0) {
        $author = $result_author->fetch_assoc();
        $autori_id = $author['id'];
    } else {
        echo "Gabim: Nuk u gjet asnjë drejtor me këtë emër dhe mbiemër.";
        exit;
    }

    // Futja e njoftimit në databazë
    $sql = $conn->prepare("INSERT INTO njoftimet (titulli, pershkrimi, data, autori_id) VALUES (?, ?, ?, ?)");
    $sql->bind_param("sssi", $titulli, $pershkrimi, $data, $autori_id);

    if ($sql->execute()) {
        echo "success";
    } else {
        echo "Gabim: " . $sql->error;
    }

    $sql_author->close();
    $sql->close();
}

$conn->close();
?>
