<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../includes/db.php';

    $nxenesi_id = $_POST['nxenesi'];
    $lenda_id = $_POST['lenda'];
    $periudha = $_POST['periudha'];

    // Kontrollo dhe filtro notat
    $nota1 = isset($_POST['nota1']) && $_POST['nota1'] !== '' ? (int)$_POST['nota1'] : null;
    $nota2 = isset($_POST['nota2']) && $_POST['nota2'] !== '' ? (int)$_POST['nota2'] : null;
    $nota_p = isset($_POST['nota_p']) && $_POST['nota_p'] !== '' ? (int)$_POST['nota_p'] : null;

    // Kontrollo nëse ekziston një rresht
    $check = $conn->prepare("SELECT id FROM notat WHERE nxenesi_id = ? AND lenda_id = ? AND periudha = ?");
    $check->bind_param("iis", $nxenesi_id, $lenda_id, $periudha);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Rreshti ekziston → UPDATE vetëm për fushat e dhëna
        $check->bind_result($id);
        $check->fetch();

        $fields = [];
        $params = [];
        $types = "";

        if ($nota1 !== null) {
            $fields[] = "nota1 = ?";
            $params[] = $nota1;
            $types .= "i";
        }
        if ($nota2 !== null) {
            $fields[] = "nota2 = ?";
            $params[] = $nota2;
            $types .= "i";
        }
        if ($nota_p !== null) {
            $fields[] = "nota_perfundimtare = ?";
            $params[] = $nota_p;
            $types .= "i";
        }

        if (!empty($fields)) {
            $sql = "UPDATE notat SET " . implode(", ", $fields) . " WHERE id = ?";
            $params[] = $id;
            $types .= "i";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                echo "Sukses";
            } else {
                echo "Gabim gjatë përditësimit: " . $conn->error;
            }

            $stmt->close();
        } else {
            echo "Asnjë fushë për të përditësuar.";
        }
    } else {
        // Rreshti nuk ekziston → INSERT i plotë
        $stmt = $conn->prepare("INSERT INTO notat (nxenesi_id, lenda_id, nota1, nota2, nota_perfundimtare, periudha) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiiss", $nxenesi_id, $lenda_id, $nota1, $nota2, $nota_p, $periudha);

        if ($stmt->execute()) {
            echo "Sukses";
        } else {
            echo "Gabim gjatë shtimit: " . $conn->error;
        }

        $stmt->close();
    }

    $check->close();
    $conn->close();
}
?>
