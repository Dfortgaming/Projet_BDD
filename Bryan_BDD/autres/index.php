<?php
function db_connect() {
    $hostname = 'mysql_latest';
    $port = '3306';
    $dbname = 'bryan_bdd';
    $dbuser = 'root';
    $dbpass = 'password';
    try {
        $dbh = new PDO("mysql:host=$hostname;port=$port;dbname=$dbname", $dbuser, $dbpass);        
    } catch(PDOException $exception) {
    var_dump($exception->getMessage( ));
    var_dump($exception->getCode( ));
     }
    return $dbh;
}


function connectToDatabase(PDO $database_handler) {

    $sql = "SELECT * FROM bryan_bdd;";
    $data = [];

    $sth = $database_handler->prepare($sql);
    $is_successful = $sth->execute($data);

    assert ($is_successful, "Error while connecting to the database");




}







?>