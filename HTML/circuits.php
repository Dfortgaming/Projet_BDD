<?php
session_start();
require_once '../PHP/database.php';

$dbh = db_connect();
$client = check_auth_and_logout($dbh);
// Récupère l'intégralité des circuits enregistrés dans la table Circuit
$circuits = select_all_Circuit($dbh);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./style/bryan_style.css?v=5">

    <title>Bryan's Tour - Tous les circuits</title>

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
                <a href="./circuits.php" class="p_link_a">Circuits</a>
                <a href="./reservations.php" class="p_link">Réservations</a>
            </nav>

        </header>

        <section class="preview" id="accueil">

            <h1>
                Circuits disponibles pour le Bryan
                <span>Tour</span>
            </h1>

            <div class="subtitle">
                <h3>
                    Découvrez le circuit qui remplira vos critères et profitez d'une activité qui mêle découverte et loisir !
                </h3>
            </div>

        </section>

        <div class="content">
            <div class="tete">
                <div class="title-content">Nos Circuits</div>
            </div>

            <section class="items">
                <?php foreach ($circuits as $circuit): ?>
                    <div class="circ">
                        <div class="top">
                            <div class="type"><?= htmlspecialchars($circuit['pays']) ?></div>
                            <div class="title-circ"><?= htmlspecialchars($circuit['nom_circuit']) ?></div>
                            <div class="steps">
                                <?= htmlspecialchars($circuit['ville_depart']) ?> &rarr; <?= htmlspecialchars($circuit['ville_arrivee']) ?> (<?= htmlspecialchars($circuit['duree']) ?> j)
                            </div>
                            <div class="desc">
                                <?= htmlspecialchars($circuit['descriptif'] ?? 'Aucune description disponible.') ?>
                            </div>
                        </div>

                        <div class="bottom">
                            <div class="prix"><?= htmlspecialchars($circuit['prix_inscription']) ?> €</div>
                            <div class="places"><?= htmlspecialchars($circuit['nbr_places_disponibles']) ?> places</div>
                            <a href="reservations.php?id=<?= $circuit['Id_Circuit'] ?>" class="order" style="text-decoration: none; display: inline-block;">Réserver</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </div>
    </main>
</body>
</html>