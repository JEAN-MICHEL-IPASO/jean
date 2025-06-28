<?php	
include 'db.php';
$nom = $_POST['nom'];
$age = $_POST['age'];
$sexe = $_POST['sexe'];
$adresse = $_POST['adresse'];
$responsable = $_POST['responsable'];
$date = $_POST['date_consultation'];
$provenance = $_POST['provenance'];
$aire = $_POST['aire_sante'];
$telephone = $_POST['telephone'];
$taille = $_POST['taille'];
$diagnostic = $_POST['diagnostic'];

$conn->query("INSERT INTO patients (nom, age, sexe, adresse, responsable, date_consultation, provenance, aire_sante, telephone, taille)
VALUES ('$nom', $age, '$sexe', '$adresse', '$responsable', '$date', '$provenance', '$aire', '$telephone', $taille)");

$patient_id = $conn->insert_id;

$conn->query("INSERT INTO consultation (patient_id, date, diagnostic)
VALUES ($patient_id, '$date', '$diagnostic')");

echo "Consultation enregistrée avec succès.";
?>
