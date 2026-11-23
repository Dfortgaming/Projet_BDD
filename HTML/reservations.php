<?php
session_start();
require_once '../PHP/database.php';

$dbh = db_connect();
$client = check_auth_and_logout($dbh);

$feedback = null;

// Traitement du formulaire lors du clic sur "Réserver"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['circuit_id'])) {
    $circuitId = (int)$_POST['circuit_id'];
    if ($circuitId > 0) {
        $feedback = create_reservation($dbh, (int)$client['id'], $circuitId);
    } else {
        $feedback = ['success' => false, 'message' => "Veuillez sélectionner un circuit valide."];
    }
}

$circuits = select_all_Circuit($dbh);
$selectedId = isset($_POST['circuit_id']) ? (int)$_POST['circuit_id'] : (isset($_GET['id']) ? (int)$_GET['id'] : null);
$selectedCircuit = $selectedId ? select_one_Circuit($dbh, $selectedId) : null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./style/bryan_style.css?v=5">

    <title>Bryan's Tour - Réservations</title>

    <script src="./script/script.js?v=5" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body>
    <main>
        <header class="d_blue">

            <div class="nav-top">

                <button
                    class="menu-toggle"
                    id="menu-toggle"
                    aria-label="Ouvrir le menu"
                    aria-expanded="false"
                    aria-controls="pages">
                    ☰
                </button>

                <a href="./homepage.php" class="title_header">
                    <div class="title_w">Bryan</div>
                    <div class="title_b">Tour</div>
                </a>

                <div class="account-wrapper">
                    <button type="button" class="account" id="account-btn" aria-expanded="false" aria-controls="account-dropdown">
                        Mon compte
                    </button>

                    <div class="account-dropdown" id="account-dropdown">
                        <div class="account-info">
                            <p class="account-name">
                                <?= htmlspecialchars($client['prenom']) ?> <?= htmlspecialchars($client['nom']) ?>
                            </p>
                            <p class="account-detail">
                                <strong>Email :</strong> <?= htmlspecialchars($client['email']) ?>
                            </p>
                            <p class="account-detail">
                                <strong>Téléphone :</strong> <?= htmlspecialchars($client['telephone']) ?>
                            </p>
                        </div>
                        <a href="?action=logout" class="logout-btn">Logout</a>
                    </div>
                </div>

            </div>

            <nav class="pages" id="pages">
                <a href="./homepage.php" class="p_link">Accueil</a>
                <a href="./circuits.php" class="p_link">Circuits</a>
                <a href="./reservations.php" class="p_link_a">Réservations</a>
            </nav>

        </header>

        <section class="preview" id="accueil">

            <div class="sticker">
                Espace de réservation
            </div>

            <h1>
                Réservez votre
                <span>expérience unique</span>
            </h1>

            <div class="subtitle">
                <h3>
                    Planifiez dès aujourd'hui votre circuit thématique sur les traces des personnalités marquantes nommées Bryan.
                </h3>
            </div>

        </section>

        <section class="content_res">

            <?php if ($feedback): ?>
                <div style="margin: 1rem; padding: 1rem; border-radius: 10px; font-weight: 600; text-align: center; background-color: <?= $feedback['success'] ? '#DCFCE7' : '#FEE2E2' ?>; color: <?= $feedback['success'] ? '#166534' : '#991B1B' ?>; border: 1px solid <?= $feedback['success'] ? '#86EFAC' : '#FCA5A5' ?>;">
                    <?= htmlspecialchars($feedback['message']) ?>
                </div>
            <?php endif; ?>

            <div class="choice">
                <div class="header">
                    <div class="number">1</div>
                    <div class="title">Choisissez votre circuit</div>
                </div>
                <div class="content">
                    <?php foreach ($circuits as $circuit): ?>
                        <div class="<?= ($selectedId === (int)$circuit['Id_Circuit']) ? 'circ_disp_p' : 'circ_disp' ?>" onclick="window.location.href='reservations.php?id=<?= $circuit['Id_Circuit'] ?>'" style="cursor: pointer;">
                            <div class="top">
                                <div class="type"><?= htmlspecialchars($circuit['pays']) ?></div>
                                <div class="prix"><?= htmlspecialchars($circuit['prix_inscription']) ?> €</div>
                            </div>
                            <div class="mid">
                                <div class="title-circ"><?= htmlspecialchars($circuit['nom_circuit']) ?></div>
                                <div class="steps">
                                    <?= htmlspecialchars($circuit['ville_depart']) ?> &rarr; <?= htmlspecialchars($circuit['ville_arrivee']) ?>
                                </div>
                                <div class="desc">
                                    <?= htmlspecialchars($circuit['descriptif'] ?? 'Aucune description disponible.') ?>
                                </div>
                            </div>
                            <div class="bottom" style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="during_time">
                                    Durée : <?= htmlspecialchars($circuit['duree']) ?> jours (<?= htmlspecialchars($circuit['nbr_places_disponibles']) ?> places)
                                </div>
                                <form action="reservations.php" method="post" style="margin: 0;" onclick="event.stopPropagation();">
                                    <input type="hidden" name="circuit_id" value="<?= $circuit['Id_Circuit'] ?>">
                                    <button type="submit" class="order" style="cursor: pointer;">Réserver</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </section>
    </main>
</body>
</html>