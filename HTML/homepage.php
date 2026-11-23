<?php
session_start();
require_once '../PHP/database.php';

$dbh = db_connect();
$client = check_auth_and_logout($dbh);
$circuits = select_featured_circuits($dbh, [1, 2, 6]);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./style/bryan_style.css?v=5">

    <title>Bryan's Tour</title>

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
                <a href="./homepage.php" class="p_link_a">Accueil</a>
                <a href="./circuits.php" class="p_link">Circuits</a>
                <a href="./reservations.php" class="p_link">Réservations</a>
            </nav>

        </header>

        <section class="preview" id="accueil">

            <div class="sticker">
                AGENCE DE VOYAGE EXCLUSIVE
            </div>

            <h1>
                Explorez le monde avec les
                <span>grands Bryan</span>
            </h1>

            <div class="subtitle">
                <h3>
                    Des circuits thématiques uniques sur les traces
                    des personnalités marquantes nommées Bryan :
                    cinéma, sport et légende locale.
                </h3>
            </div>

        </section>

        <div class="content">
            <div class="tete">
                <div class="title-content">Nos principaux Circuits</div>
                <a href="./circuits.php" class="p-circuit">Voir tous nos circuits →</a>
            </div>

            <section class="items">
                <?php foreach ($circuits as$circuit): ?>
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

        <footer id="contact" class="contact-section">
            <div class="contact-container">
                <h2>Contactez-<span>nous !</span></h2>
                <p>Une question sur un circuit ou une réservation ? Notre équipe est à votre écoute.</p>
                <div class="contact-infos">
                    <div class="contact-item">
                        <span>Email :</span>
                        <a href="mailto:contact@bryantour.fr">contact@bryantour.fr</a>
                    </div>
                    <div class="contact-item">
                        <span>Téléphone :</span>
                        <a href="tel:+33299000000">02 99 00 00 00</a>
                    </div>
                </div>
            </div>
        </footer>
    </main>
</body>
</html>