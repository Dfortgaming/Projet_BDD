<?php
session_start();
require_once '../PHP/database.php';

$PASSWORD_MIN_LEN = 8;
$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom       = trim($_POST['lastname'] ?? '');
    $prenom    = trim($_POST['firstname'] ?? '');
    $telephone = trim($_POST['phone'] ?? '');
    $email     = filter_var(trim($_POST['mail'] ?? ''), FILTER_VALIDATE_EMAIL);
    $password  = $_POST['pssword'] ?? '';

    if (empty($nom) || empty($prenom) || empty($email) || empty($telephone) || strlen($password) < $PASSWORD_MIN_LEN) {
        $message = "Veuillez renseigner tous les champs obligatoires (mot de passe de 8 caractères minimum).";
    } else {
        $dbh = db_connect();
        
        // Vérifie si l'email existe déjà en base (fonction déjà utilisée dans votre login.php)
        if (get_user_by_email($dbh, $email)) {
            $message = "Cette adresse email est déjà utilisée.";
        } else {
            // Appel de votre fonction d'insertion (assurez-vous qu'elle existe bien dans database.php)
            client_creation($dbh, $_POST);
            
            header('Location: login.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/login.css">
    <title>BryanTour - Inscription</title>
</head>
<body>
    <div class="main">
        <div class="form">
            <p class="title">Bryan<span>Tour</span></p>
            <p class="important-text">Enregistres-toi !</p>

            <?php if ($message): ?>
                <p style="color: red; text-align: center;"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <div class="form-label">
                <form action="register.php" method="post">
                    <ul>
                        <li>
                            <label for="lastname" class="important-text">Nom</label>
                            <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>" required>
                        </li>
                        <li>
                            <label for="firstname" class="important-text">Prénom</label>
                            <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>" required>
                        </li>
                        <li>
                            <label for="mail" class="important-text">Email</label>
                            <input type="email" id="mail" name="mail" value="<?= htmlspecialchars($_POST['mail'] ?? '') ?>" required>
                        </li>
                        <li>
                            <label for="pssword" class="important-text">Mot de passe</label>
                            <input type="password" id="pssword" name="pssword" minlength="8" required>
                        </li>
                        <li>
                            <label for="phone" class="important-text">Téléphone</label>
                            <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required>
                        </li>
                    </ul>
                    <div class="connection">
                        <button class="button-connection" type="submit">S'enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>