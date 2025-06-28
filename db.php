<?php
$host = 'localhost';
$user = 'root';
$password = ''; // modifie selon ton config
$database = 'hopital';

$conn = new mysqli($host, $user, $password, $database);

// Gestion des erreurs
if ($conn->connect_error) {
    die("Connexion échouée: ". $conn->connect_error);
}
?>

