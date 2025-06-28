<?php
include 'db.php';
$nom = $_POST['nom'];
$age = $_POST['age'];
$sexe = $_POST['sexe'];
$date = $_POST['date'];
$medicaments = $_POST['medicaments'];
$conn->query("INSERT INTO patients (nom, age, sexe) VALUES ('$nom', $age, '$sexe')");
$patient_id = $conn->insert_id;
	
$conn->query("INSERT INTO ordonnance (patient_id, date, medicaments) VALUES ($patient_id, '$date', '$medicaments')");
echo "Ordonnance enregistrée avec succès.";
?>
