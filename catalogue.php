<?php
session_start();
require_once 'db.php';

// Récupération de tous les circuits
$stmt = $pdo->query("
    SELECT Id_Circuit, Nom_circuit, descriptif, Pays, villeDepart, villeArrivee, dateDepart, nbrPlacesDisponibles, duree, prixInscription 
    FROM Circuit 
    ORDER BY dateDepart ASC
");
$circuits = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Catalogue des Circuits</title>
</head>
<body>
    <header>
        <nav>
            <a href="catalogue.php">Catalogue</a> |
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="accueil.php">Mon Espace Client</a> |
                <?php if (!empty($_SESSION['is_admin'])): ?>
                    <a href="admin.php">Administration</a> |
                <?php endif; ?>
                <a href="logout.php">Déconnexion</a>
            <?php else: ?>
                <a href="login.php">Connexion</a> |
                <a href="register.php">Inscription</a>
            <?php endif; ?>
        </nav>
    </header>

    <h1>Nos offres de voyages et circuits</h1>

    <div class="circuits-list">
        <?php foreach ($circuits as $circuit): ?>
            <article style="border: 1px solid #aaa; margin: 15px 0; padding: 15px;">
                <h2><?= htmlspecialchars($circuit['Nom_circuit']) ?> (<?= htmlspecialchars($circuit['Pays']) ?>)</h2>
                <p><strong>Itinéraire :</strong> de <?= htmlspecialchars($circuit['villeDepart']) ?> à <?= htmlspecialchars($circuit['villeArrivee']) ?></p>
                <p><strong>Départ :</strong> <?= htmlspecialchars($circuit['dateDepart']) ?> | <strong>Durée :</strong> <?= htmlspecialchars($circuit['duree']) ?> jours</p>
                <p><strong>Prix :</strong> <?= htmlspecialchars($circuit['prixInscription']) ?> €</p>
                <p><strong>Places restantes :</strong> <?= htmlspecialchars($circuit['nbrPlacesDisponibles']) ?></p>
                <p><?= nl2br(htmlspecialchars($circuit['descriptif'])) ?></p>
                <a href="circuit_detail.php?id=<?= $circuit['Id_Circuit'] ?>">Consulter le programme détaillé</a>
            </article>
        <?php endforeach; ?>
    </div>
</body>
</html>