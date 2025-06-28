<?php
include 'db.php';
session_start();

$patient_id = intval($_POST['patient_id']);
$date       = $_POST['date'];
$type       = trim($_POST['type']);
$resultat   =!empty($_POST['resultat'])? trim($_POST['resultat']): null;
$statut     = $_POST['statut'];

$stmt = $conn->prepare("
  INSERT INTO examens (patient_id, date, type, resultat, statut)
  VALUES (?,?,?,?,?)
");
$stmt->bind_param("issss", $patient_id, $date, $type, $resultat, $statut);
$stmt->execute();

header("Location: vue_labo.php");
exit;
?>
