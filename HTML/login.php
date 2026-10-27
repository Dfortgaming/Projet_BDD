<?php
session_start();

require_once '../PHP/database.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['mail'] ?? '');
    $password = $_POST['pssword'] ?? '';

    if (!empty($email) && !empty($password)) {
        $dbh = db_connect();
        $user = get_user_by_email($dbh, $email);

        // Vérification de la correspondance (en texte brut pour l'instant)
        if ($user && $user['mot_de_passe'] === $password) {
            $_SESSION['user_id'] = $user['Id_client'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['admin'] = $user['admin'];

            header('Location: homepage.php');
            exit();
        } else {
            $error = "Identifiants incorrects.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/login.css">
    <title>BryanTour</title>
</head>
<body>
    <div class="main">
        <div class="form">
            <p class="title">Bryan<span>Tour</span></p>
            <p class="important-text">Page d'accueil</p>
            <?php if ($error): ?>
                <p style="color: red; text-align: center;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <div class="form-label">
                <form action="login.php" method="post">
                    <ul>
                        <li>
                            <label for="mail" class="important-text">Adresse mail</label>
                            <input type="email" id="mail" name="mail" required>
                        </li>
                        <li>
                            <label for="pssword" class="important-text">Mot de passe :</label>
                            <input type="password" id="pssword" name="pssword" required>
                        </li>
                    </ul>
                    <div class="widget-login"> 
                        <label>
                            <input type="checkbox" name="remember-me" value="remember-me">
                            Se souvenir de moi
                        </label>
                        <label class="important-text">
                            <a href="#">Mot de passe oublié ?</a>
                        </label>
                    </div>
                    <div class="connection">
                        <button class="button-connection" type="submit">Se connecter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>