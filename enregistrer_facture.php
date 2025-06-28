<?php
include 'db.php';
session_start();

// Vérifier que tous les champs sont présents
$champs = ['patient_id', 'numero_facture', 'date', 'designation', 'quantite', 'prix_unitaire'];
foreach ($champs as $champ) {
  if (empty($_POST[$champ])) {
    exit("❌ Champ requis manquant: $champ");
}
}

// Nettoyer et récupérer les données
$patient_id      = intval($_POST['patient_id']);
$numero_facture  = trim($_POST['numero_facture']);
$date            = $_POST['date'];
$designation     = trim($_POST['designation']);
$quantite        = floatval($_POST['quantite']);
$prix_unitaire   = floatval($_POST['prix_unitaire']);

// Calculs automatiques
$prix_total = $quantite * $prix_unitaire;
$montant_global = $prix_total; // Si une seule ligne par facture, sinon adapter

// Insertion sécurisée
$stmt = $conn->prepare("
  INSERT INTO facture (
    patient_id, numero_facture, date, designation,
    quantite, prix_unitaire, prix_total, montant_global
) VALUES (?,?,?,?,?,?,?,?)
");

$stmt->bind_param(
  "isssdddd",
 $patient_id, $numero_facture, $date, $designation,
  $quantite, $prix_unitaire, $prix_total, $montant_global
);

$stmt->execute();

// Rediriger vers l’affichage de la facture
$id = $conn->insert_id;
header("Location: facture.php?id=$id");
exit;
?>
