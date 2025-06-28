<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "hopital");

if ($conn->connect_error) {
    die("Connexion échouée: ". $conn->connect_error);
}

// Vérification des paramètres GET
if (isset($_GET["id"]) && isset($_GET["statut"])) {
    $id = intval($_GET["id"]);
    $statut = $conn->real_escape_string($_GET["statut"]);

    // Requête SQL sécurisée
    $sql = "UPDATE rendez_vous SET statut = '$statut' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Statut mis à jour avec succès.";
} else {
        echo "Erreur lors de la mise à jour: ". $conn->error;
}
} else {
    echo "Paramètres manquants.";
}

$conn->close();
?>
