<!-- Dans la page login -->
<?php
session_start();
require_once 'db.php';

// Si l'utilisateur est déjà connecté, redirection vers l'accueil
if (isset($_SESSION['user_id'])) {
    header('Location: accueil.php');
    exit;
}

$message = '';

if (isset($_GET['registered'])) {
    $message = "Inscription validée ! Vous pouvez maintenant vous connecter.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Recherche de l'utilisateur par son email
    $stmt = $pdo->prepare("SELECT Id_client, nom, prenom, MP, Admin FROM Client WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Vérification du mot de passe haché dans la colonne MP
    if ($user && password_verify($password, $user['MP'])) {
        session_regenerate_id(true); // Protection contre la fixation de session
        $_SESSION['user_id']   = $user['Id_client'];
        $_SESSION['user_nom']  = $user['prenom'] . ' ' . $user['nom'];
        $_SESSION['is_admin']  = ((int)$user['Admin'] === 1);

        header('Location: accueil.php');
        exit;
    } else {
        $message = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion - Agence de Tourisme</title>
</head>
<body>
    <h2>Connexion à votre espace</h2>
    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>E-mail : <input type="email" name="email" required></label><br><br>
        <label>Mot de passe : <input type="password" name="password" required></label><br><br>
        <button type="submit">Se connecter</button>
    </form>
    <p>Pas encore inscrit ? <a href="register.php">Créer un compte</a>.</p>
</body>
</html>