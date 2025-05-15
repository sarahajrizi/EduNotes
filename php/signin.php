<?php
session_start();
if (isset($_SESSION['roli'])) {
    switch ($_SESSION['roli']) {
        case 'drejtor':
            header("Location: drejtor/dashboard.php");
            break;
        case 'mesues':
            header("Location: mesues/dashboard.php");
            break;
        case 'prind':
            header("Location: prind/dashboard.php");
            break;
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>EduNotes - Kyçu</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="signin-section">
        <div class="header-title">EduNotes</div>
        <div class="signin-wrapper">
            <div class="signin-container">
                <img src="img/logo.png" alt="Logo e Shkollës" class="logo">

                <form action="includes/auth.php" method="POST" class="login-form">

                    <?php if (isset($_GET['error'])): ?>
                        <p class="error-message"><?= htmlspecialchars($_GET['error']) ?></p>
                    <?php endif; ?>

                    <label for="email">Email:</label>
                    <input type="email" name="email" placeholder="Shkruani email-en tuaj" required>

                    <label for="password">Fjalëkalimi:</label>
                    <input type="password" name="fjalekalimi" placeholder="Shkruani fjalëkalimi" required>
                    <button type="submit" name="login">Kyçu</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
