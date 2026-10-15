<?php
session_start();
require_once 'db.php';

// Contrôle d'accès : redirection vers login si non connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$idClient = $_SESSION['user_id'];

// Récupération des réservations effectuées par ce client
$stmt = $pdo->prepare("
    SELECT r.status, c.Nom_circuit, c.Pays, c.dateDepart, c.prixInscription
    FROM Reservation r
    JOIN Circuit c ON r.Id_Circuit = c.Id_Circuit
    WHERE r.Id_client = ?
    ORDER BY c.dateDepart ASC
");
$stmt->execute([$idClient]);
$mesReservations = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Accueil - Espace Client</title>
</head>
<body>
    <header>
        <nav>
            <a href="accueil.php">Accueil</a> |
            <a href="catalogue.php">Catalogue des séjours</a> |
            <?php if (!empty($_SESSION['is_admin'])): ?>
                <a href="admin.php"><strong>Panneau Admin</strong></a> |
            <?php endif; ?>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>

    <h1>Bienvenue, <?= htmlspecialchars($_SESSION['user_nom'] ?? '') ?> !</h1>

    <?php if (isset($_GET['booking_success'])): ?>
        <p style="color: green;"><strong>Votre réservation a été enregistrée avec succès !</strong></p>
    <?php endif; ?>

    <h2>Mes réservations</h2>
    <?php if (empty($mesReservations)): ?>
        <p>Vous n'avez pas encore de réservation. <a href="catalogue.php">Découvrir nos circuits</a>.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Circuit</th>
                    <th>Pays</th>
                    <th>Date de départ</th>
                    <th>Tarif</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mesReservations as $res): ?>
                    <tr>
                        <td><?= htmlspecialchars($res['Nom_circuit']) ?></td>
                        <td><?= htmlspecialchars($res['Pays']) ?></td>
                        <td><?= htmlspecialchars($res['dateDepart']) ?></td>
                        <td><?= htmlspecialchars($res['prixInscription']) ?> €</td>
                        <td><strong><?= htmlspecialchars($res['status']) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>