<?php
session_start();
require_once 'db.php';

// Si non connecté, redirection vers le login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: catalogue.php');
    exit;
}

$idClient  = $_SESSION['user_id'];
$idCircuit = filter_input(INPUT_POST, 'id_circuit', FILTER_VALIDATE_INT);

if (!$idCircuit) {
    die("Identifiant de circuit invalide.");
}

try {
    $pdo->beginTransaction();

    // 1. Vérification et verrouillage des places disponibles
    $stmt = $pdo->prepare("SELECT nbrPlacesDisponibles FROM Circuit WHERE Id_Circuit = ? FOR UPDATE");
    $stmt->execute([$idCircuit]);
    $circuit = $stmt->fetch();

    if (!$circuit || $circuit['nbrPlacesDisponibles'] <= 0) {
        $pdo->rollBack();
        die("Désolé, ce circuit n'a plus de place disponible.");
    }

    // 2. Vérification d'un doublon de réservation pour ce client
    $check = $pdo->prepare("SELECT Id_client FROM Reservation WHERE Id_client = ? AND Id_Circuit = ?");
    $check->execute([$idClient, $idCircuit]);
    if ($check->fetch()) {
        $pdo->rollBack();
        die("Vous avez déjà effectué une réservation pour ce circuit.");
    }

    // 3. Création de la réservation avec le statut 'Confirmée'
    $insert = $pdo->prepare("INSERT INTO Reservation (Id_client, Id_Circuit, status) VALUES (?, ?, ?)");
    $insert->execute([$idClient, $idCircuit, 'Confirmée']);

    // 4. Décrémentation du nombre de places
    $update = $pdo->prepare("UPDATE Circuit SET nbrPlacesDisponibles = nbrPlacesDisponibles - 1 WHERE Id_Circuit = ?");
    $update->execute([$idCircuit]);

    $pdo->commit();

    // Redirection vers accueil.php avec indicateur de succès
    header('Location: accueil.php?booking_success=1');
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    die("Erreur lors de la réservation : " . $e->getMessage());
}