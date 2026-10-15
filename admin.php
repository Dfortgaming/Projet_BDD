<?php
session_start();
require_once 'db.php';

// Restriction : uniquement pour les administrateurs connectés
if (!isset($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('Location: accueil.php');
    exit;
}

$message = '';

// Action 1 : Mise à jour du statut d'une réservation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $idClient  = filter_input(INPUT_POST, 'id_client', FILTER_VALIDATE_INT);
    $idCircuit = filter_input(INPUT_POST, 'id_circuit', FILTER_VALIDATE_INT);
    $nouveauStatus = trim($_POST['status'] ?? '');

    if ($idClient && $idCircuit && !empty($nouveauStatus)) {
        $stmtStatus = $pdo->prepare("UPDATE Reservation SET status = ? WHERE Id_client = ? AND Id_Circuit = ?");
        $stmtStatus->execute([$nouveauStatus, $idClient, $idCircuit]);
        $message = "Statut de la réservation mis à jour.";
    }
}

// Action 2 : Ajout d'un nouveau circuit touristique
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_circuit'])) {
    $nomCircuit = trim($_POST['Nom_circuit'] ?? '');
    $descriptif = trim($_POST['descriptif'] ?? '');
    $pays       = trim($_POST['Pays'] ?? '');
    $villeDep   = trim($_POST['villeDepart'] ?? '');
    $villeArr   = trim($_POST['villeArrivee'] ?? '');
    $dateDep    = $_POST['dateDepart'] ?? '';
    $places     = filter_input(INPUT_POST, 'nbrPlacesDisponibles', FILTER_VALIDATE_INT);
    $duree      = filter_input(INPUT_POST, 'duree', FILTER_VALIDATE_INT);
    $prix       = filter_input(INPUT_POST, 'prixInscription', FILTER_VALIDATE_INT);

    if ($nomCircuit && $pays && $dateDep && $places !== false && $prix !== false) {
        $stmtAdd = $pdo->prepare("
            INSERT INTO Circuit (Nom_circuit, descriptif, Pays, villeDepart, villeArrivee, dateDepart, nbrPlacesDisponibles, duree, prixInscription)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmtAdd->execute([$nomCircuit, $descriptif, $pays, $villeDep, $villeArr, $dateDep, $places, $duree, $prix]);
        $message = "Circuit ajouté avec succès.";
    } else {
        $message = "Formulaire incomplet pour la création du circuit.";
    }
}

// Liste de toutes les réservations avec les données clients et circuits
$reservations = $pdo->query("
    SELECT r.Id_client, r.Id_Circuit, r.status, c.Nom_circuit, cl.nom, cl.prenom, cl.email
    FROM Reservation r
    JOIN Circuit c ON r.Id_Circuit = c.Id_Circuit
    JOIN Client cl ON r.Id_client = cl.Id_client
    ORDER BY c.dateDepart ASC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Back-office - Administration</title>
</head>
<body>
    <header>
        <p><a href="accueil.php">← Retour à l'accueil</a> | <a href="catalogue.php">Catalogue</a> | <a href="logout.php">Déconnexion</a></p>
    </header>

    <h1>Panneau d'administration</h1>

    <?php if ($message): ?>
        <p style="background: #e8f4fd; padding: 10px; border-left: 4px solid #2196F3;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <h2>Ajouter un nouveau circuit</h2>
    <form method="POST">
        <input type="hidden" name="create_circuit" value="1">
        <label>Nom du circuit : <input type="text" name="Nom_circuit" required></label><br><br>
        <label>Pays : <input type="text" name="Pays" required></label><br><br>
        <label>Ville de départ : <input type="text" name="villeDepart" required></label><br><br>
        <label>Ville d'arrivée : <input type="text" name="villeArrivee" required></label><br><br>
        <label>Date et heure de départ : <input type="datetime-local" name="dateDepart" required></label><br><br>
        <label>Nombre de places : <input type="number" name="nbrPlacesDisponibles" min="1" required></label><br><br>
        <label>Durée (jours) : <input type="number" name="duree" min="1" required></label><br><br>
        <label>Prix d'inscription (€) : <input type="number" name="prixInscription" min="0" required></label><br><br>
        <label>Descriptif :<br><textarea name="descriptif" rows="4" cols="50"></textarea></label><br><br>
        <button type="submit">Enregistrer le circuit</button>
    </form>

    <hr>

    <h2>Réservations des clients</h2>
    <?php if (empty($reservations)): ?>
        <p>Aucune réservation en cours.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Email</th>
                    <th>Circuit réservé</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $res): ?>
                    <tr>
                        <td><?= htmlspecialchars($res['nom'] . ' ' . $res['prenom']) ?></td>
                        <td><?= htmlspecialchars($res['email']) ?></td>
                        <td><?= htmlspecialchars($res['Nom_circuit']) ?></td>
                        <td><?= htmlspecialchars($res['status']) ?></td>
                        <td>
                            <form method="POST" style="margin: 0;">
                                <input type="hidden" name="update_status" value="1">
                                <input type="hidden" name="id_client" value="<?= $res['Id_client'] ?>">
                                <input type="hidden" name="id_circuit" value="<?= $res['Id_Circuit'] ?>">
                                <select name="status">
                                    <option value="En attente" <?= $res['status'] === 'En attente' ? 'selected' : '' ?>>En attente</option>
                                    <option value="Confirmée" <?= $res['status'] === 'Confirmée' ? 'selected' : '' ?>>Confirmée</option>
                                    <option value="Annulée" <?= $res['status'] === 'Annulée' ? 'selected' : '' ?>>Annulée</option>
                                </select>
                                <button type="submit">Valider</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>