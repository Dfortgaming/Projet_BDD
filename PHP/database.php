<?php

function db_connect() {
    include "config.php";
    
    try {
        $dbh = new PDO("mysql:host=$host:$port;dbname=$dbname", $dbuser, $dbpass);
    } 
    catch(PDOException $exception) {
    
         var_dump($exception->getMessage( ));
         var_dump($exception->getCode( ));
    }
    return $dbh;
}
function select_all_Circuit(PDO $database_handler) {
    // Check that the database is properly set and try reading records

    // TODO: STEP 1 : Fix the credentials set above so that the connection works on your computer on your local database.

    $sql = "SELECT * FROM Circuit;";
    $data = [];

    $sth = $database_handler->prepare($sql);
    $is_successful = $sth->execute($data);
    $data = $sth->fetchAll();

    assert ($is_successful, "Error while connecting to the database");

    // FIXME: STEP 2 : Please define the configuration variables in an external file `config.php`  untracked by git
    // FIXME: STEP 3 : Even better than using a `config.php` file, use a `.env` file.
    return $data;
}
function select_one_Circuit(PDO $database_handler, int $id) {
    $sql = "SELECT * FROM Circuit WHERE Id_Circuit = :id";
    $sth = $database_handler->prepare($sql);
    $sth->execute(['id' => $id]);
    
    return $sth->fetch(PDO::FETCH_ASSOC); // Renvoie directement les colonnes : ['nom' => '...', ...]
}

function insert_Circuit(PDO $database_handler, Array $circuit) {
    // Create a record in the database.

    // TODO: Your code comes here ! 
    $sql = "INSERT INTO Circuit(descriptif, pays, ville_depart, ville_arrivee, date_depart, nbr_places_disponibles, duree, prix_inscription, nom_circuit) 
    VALUES (:descriptif, :pays, :ville_depart, :ville_arrivee, :date_depart, :nbr_places_disponibles, :duree, :prix_inscription, :nom_circuit) ";
    $sth = $database_handler->prepare($sql);
    $is_successful = $sth->execute($circuit);
    // try{
        
    // }catch (PDOException exception)
  
    
    // Checking that you did the expected work
    // $nom = $group["nom"];
    // $result = $database_handler->query("SELECT count(*) FROM Groupes WHERE nom = '$nom'")->fetchColumn();
    // if ($result == 0){
    //     throw new AssertionError("You have not created the group record $nom in the database...");
    // }
}

function update_Circuit(PDO $dbh, string $nom,  Array $champs){
    // Update a record in the database. The record is specified by it's name value, a list of fields is given in the array

    // TODO: Your code comes here ! 
    $sql = "UPDATE Circuit SET descriptif = :descriptif, pays = :pays, ville_depart = :ville_depart, ville_arrivee = :ville_arrivee,
    date_depart= :date_depart, nbr_places_disponibles =:nbr_places_disponibles, duree = :duree, prix_inscription = :prix_inscription, 
    nom_circuit =:nom_circuit WHERE nom_circuit = :nom";
    $sth = $dbh->prepare($sql);
    $sth->execute([
        'descriptif'  => $champs['descriptif'],
        'pays'         => $champs['pays'],
        'ville_depart' => $champs['ville_depart'],
        'ville_arrivee'    => $champs['ville_arrivee'],
        'date_depart'        => $champs['date_depart'],
        'nbr_places_disponibles'        => $champs['nbr_places_disponibles'],
        'duree'        => $champs['duree'],
        'prix_inscription'        => $champs['prix_inscription'],
        'nom_circuit'        => $champs['nom_circuit'],
        'nom'          => $nom
    ]);

    // Checking that you did the expected work
    // $result = $dbh->query("SELECT email, photo FROM Groupes WHERE nom = '$nom'")->fetch();
    // if ($result['email'] != $champs["email"]){
    //     throw new AssertionError("You have not updated the email field for group $nom in the database...");
    // }
    // if ($result['photo'] != $champs["url"]){
    //     throw new AssertionError("You have not updated the email field for group $nom in the database...");
    // }
}
function delete_Circuit(PDO $dbh, string $nom){

    $sql = "DELETE FROM Circuit WHERE nom_circuit = :nom";
    $sth = $dbh->prepare($sql);
    $sth->execute(['nom' => $nom]);


    $result = $dbh->query("SELECT count(*) FROM Circuit WHERE nom = '$nom'")->fetchColumn();
    if ($result != 0){
        throw new AssertionError("You have not deleted the group record $nom in the database...");
    }
}
function get_user_by_email(PDO $dbh, string $email) {
    $sql = "SELECT * FROM Client WHERE email = :email";
    $sth = $dbh->prepare($sql);
    $sth->execute(['email' => $email]);
    return $sth->fetch(PDO::FETCH_ASSOC);
}
function select_featured_circuits(PDO $dbh, array $ids = [1, 2, 4]): array {
    if (empty($ids)) return [];

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "SELECT * FROM Circuit WHERE Id_Circuit IN ($placeholders)";
    $sth = $dbh->prepare($sql);
    $sth->execute($ids);
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}