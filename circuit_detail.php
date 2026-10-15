<?php
session_start();
require_once 'db.php';

$idCircuit = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$idCircuit) {
    header('Location: catalogue.php');
    exit;
}

// 1. Informations du circuit
$stmt = $pdo->prepare("SELECT * FROM Circuit WHERE Id_Circuit = ?");
$stmt->execute([$idCircuit]);
$circuit = $stmt->fetch();

if (!$circuit) {
    die("Circuit non trouvé.");
}

// 2. Récupération des étapes et lieux liés
$sql = "SELECT e.dateEtape, e.duree, l.ville, l.label, l.descriptif, l.Prix_visite
        FROM Ordre_de_passage op
        JOIN Etape e ON op.Id_Etape = e.Id_Etape
        JOIN Lieu l ON e.Id_Lieu = l.Id_Lieu
        WHERE op.Id_Circuit = ?
        ORDER BY e.dateEtape ASC";

$stmtEtapes = $pdo->prepare($sql);
$stmtEtapes->execute([$idCircuit]);
$etapes = $stmtEtapes->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($circuit['Nom_circuit']) ?></title>
</head>
<body>
    <p><a href="catalogue.php">← Retour au catalogue</a> | <a href="accueil.php">Mon Espace</a></p>

    <h1><?= htmlspecialchars($circuit['Nom_circuit']) ?></h1>
    <p><?= nl2br(htmlspecialchars($circuit['descriptif'])) ?></p>
    <p><strong>Départ :</strong> <?= htmlspecialchars($circuit['dateDepart']) ?> depuis <?= htmlspecialchars($circuit['villeDepart']) ?></p>
    <p><strong>Prix :</strong> <?= htmlspecialchars($circuit['prixInscription']) ?> €</p>
    <p><strong>Places disponibles :</strong> <?= htmlspecialchars($circuit['nbrPlacesDisponibles']) ?></p>

    <!-- Bouton de réservation -->
    <?php if ($circuit['nbrPlacesDisponibles'] > 0): ?>
        <form method="POST" action="reserver.php">
            <input type="hidden" name="id_circuit" value="<?= $circuit['Id_Circuit'] ?>">
            <button type="submit" style="padding: 10px 20px; font-size: 16px;">Réserver ce séjour</button>
        </form>
    <?php else: ?>
        <p style="color: red; font-weight: bold;">Complet (Plus de places disponibles)</p>
    <?php endif; ?>

    <h2>Programme des étapes et visites</h2>
    <?php if (empty($etapes)): ?>
        <p>Les étapes détaillées seront bientôt publiées.</p>
    <?php else: ?>
        <ol>
            <?php foreach ($etapes as $etape): ?>
                <li style="margin-bottom: 12px;">
                    <strong><?= htmlspecialchars($etape['dateEtape']) ?></strong> : 
                    <?= htmlspecialchars($etape['label']) ?> (<?= htmlspecialchars($etape['ville']) ?>) — 
                    Durée sur place : <?= htmlspecialchars($etape['duree']) ?> h<br>
                    <em><?= htmlspecialchars($etape['descriptif']) ?></em><br>
                    Tarif d'entrée : <?= htmlspecialchars($etape['Prix_visite']) ?> €
                </li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>
</body>
</html>