<?php
/**
 * LET OP: dit bestand verwijderen in productie !!!!!
 *
 * Created by PhpStorm.
 * User: waar0003
 * Date: 21-9-2017
 * Time: 21:18
 */
// Nodig als de database wordt gebruikt in dit script
require_once 'tools/db.php';
$mysqli =  get_mysqli();

$userid = 'admin';

// Voorbeeld van het hashen van een pasword
$hashPassword = password_hash("Trustno1", PASSWORD_BCRYPT);

$sql = "INSERT INTO gebruiker(userid, password) VALUES ('$userid', '$hashPassword')";

echo $sql;