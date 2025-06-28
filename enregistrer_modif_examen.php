<?php
include 'db.php';
session_start();

$id       = intval($_POST['id']);
$date     = $_POST['date'];
$type     = trim($_POST['type']);
$resultat =!empty($_POST['resultat'])? trim($_POST['resultat']): null;
$statut   = $_POST['statut'];

$stmt = $conn->prepare("
  UPDATE examens
  SET date =?, type =?, resultat =?, statut =?
  WHERE id =?
");
$stmt->bind_param("ssssi", $date, $type, $resultat, $statut, $id);
$stmt->execute();

header("Location: vue_labo.php");
exit;
?>
