<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $fjalkalimi = $_POST['fjalekalimi'];

    $query = "SELECT * FROM users WHERE email = '$email' AND fjalkalimi = '$fjalkalimi'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['emri'] = $user['emri'];
        $_SESSION['mbiemri'] = $user['mbiemri'];
        
        $_SESSION['roli'] = $user['roli'];

        switch ($user['roli']) {
            case 'drejtor':
                header("Location: ../drejtor/dashboard.php");
                break;
            case 'mesues':
                header("Location: ../mesues/dashboard.php");
                break;
            case 'prind':
                header("Location: ../prind/dashboard.php");
                break;
            default:
                header("Location: ../signin.php?error=Roli nuk njihet");
                break;
        }
        exit();
    } else {
        header("Location: ../signin.php?error=Email ose fjalëkalim i pasaktë");
        exit();
    }
} else {
    header("Location: ../signin.php");
    exit();
}
