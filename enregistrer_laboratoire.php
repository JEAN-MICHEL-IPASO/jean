<?php
include 'db.php';
$nom = $_POST['nom'];
$age = $_POST['age'];
$sexe = $_POST['sexe'];
$adresse = $_POST['adresse'];
$date = $_POST['date'];
$examen = $_POST['examen'];
$conn->query("INSERT INTO patients (nom, age, sexe, adresse) VALUES ('$nom', $age, '$sexe', '$adresse')");
$patient_id = $conn->insert_id;

$conn->query("INSERT INTO laboratoire (patient_id, date, examen) VALUES ($patient_id, '$date', '$examen')");
echo "Bon de laboratoire enregistré.";
?>
