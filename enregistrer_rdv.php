<?php
include 'db.php';
session_start();

// Vérification des champs requis
$champs = ['patient_id', 'date_rdv', 'heure', 'motif', 'statut'];
foreach ($champs as $champ) {
  if (empty($_POST[$champ])) {
    exit("❌ Champ manquant: $champ");
}
}

// Nettoyage des données
$patient_id = intval($_POST['patient_id']);
$date_rdv   = $_POST['date_rdv'];
$heure      = $_POST['heure'];
$motif      = trim($_POST['motif']);
$statut     = $_POST['statut'];
$commentaire =!empty($_POST['commentaire'])? trim($_POST['commentaire']): null;

// Requête d'insertion
$stmt = $conn->prepare("
  INSERT INTO rendez_vous (patient_id, date_rdv, heure, motif, statut, commentaire)
  VALUES (?,?,?,?,?,?)
");
$stmt->bind_param("isssss", $patient_id, $date_rdv, $heure, $motif, $statut, $commentaire);
$stmt->execute();

// Redirection vers la liste ou confirmation
header("Location: liste_rdv.php");
exit;
?>
