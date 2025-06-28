<?php
include 'db.php';
session_start();

// Vérification des champs requis
$champs = ['id', 'date_rdv', 'heure', 'motif', 'statut'];
foreach ($champs as $champ) {
  if (empty($_POST[$champ])) {
    exit("❌ Champ manquant: $champ");
}
}

// Nettoyage des données
$id        = intval($_POST['id']);
$date_rdv  = $_POST['date_rdv'];
$heure     = $_POST['heure'];
$motif     = trim($_POST['motif']);
$statut    = $_POST['statut'];
$commentaire =!empty($_POST['commentaire'])? trim($_POST['commentaire']): null;

// Mise à jour du rendez-vous
$stmt = $conn->prepare("
  UPDATE rendez_vous
  SET date_rdv =?, heure =?, motif =?, statut =?, commentaire =?
  WHERE id =?
");
$stmt->bind_param("sssssi", $date_rdv, $heure, $motif, $statut, $commentaire, $id);
$stmt->execute();

// Redirection vers la liste
header("Location: liste_rdv.php");
exit;
?>
