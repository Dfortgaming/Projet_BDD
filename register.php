<!-- Dans la page register -->
<?php
session_start();
require_once 'db.php';

// Si l'utilisateur est déjà connecté, redirection vers l'accueil
if (isset($_SESSION['user_id'])) {
    header('Location: accueil.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom       = trim($_POST['nom'] ?? '');
    $prenom    = trim($_POST['prenom'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $email     = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $password  = $_POST['password'] ?? '';

    if (empty($nom) || empty($prenom) || !$email || strlen($password) < 8) {
        $message = "Veuillez renseigner tous les champs obligatoires (mot de passe de 8 caractères minimum).";
    } else {
        // Vérifier si l'adresse email existe déjà
        $stmt = $pdo->prepare("SELECT Id_client FROM Client WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $message = "Cette adresse email est déjà associée à un compte.";
        } else {
            // Hachage sécurisé du mot de passe
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insertion dans la table Client (Admin = 0 par défaut pour les nouveaux inscrits)
            $stmtInsert = $pdo->prepare("
                INSERT INTO Client (nom, prenom, telephone, email, MP, Admin)
                VALUES (?, ?, ?, ?, ?, 0)
            ");
            $stmtInsert->execute([$nom, $prenom, $telephone, $email, $passwordHash]);

            header('Location: login.php?registered=1');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Inscription - Agence de Tourisme</title>
</head>
<body>
    <h2>Créer un compte client</h2>
    <?php if ($message): ?>
        <p style="color: red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nom : <input type="text" name="nom" required></label><br><br>
        <label>Prénom : <input type="text" name="prenom" required></label><br><br>
        <label>Téléphone : <input type="tel" name="telephone"></label><br><br>
        <label>E-mail : <input type="email" name="email" required></label><br><br>
        <label>Mot de passe : <input type="password" name="password" required></label><br><br>
        <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà client ? <a href="login.php">Connectez-vous ici</a>.</p>
</body>
</html>