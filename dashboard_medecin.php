<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id']) || $_SESSION['role']!== 'médecin') {
    exit("⛔ Accès refusé");
}

$nom = $_SESSION['nom']?? 'Médecin';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Espace Médecin</title>
</head>
<body>
  <h2>👨‍⚕ Bonjour Dr. <?= htmlspecialchars($nom)?> 👋</h2>
  <ul>
    <li><a href="fiche_consultation.php">🩺 Consultation</a></li>
    <li><a href="ordonnance.php">💊 Ordonnance</a></li>
    <li><a href="agenda_semaine.php">📅 Agenda</a></li>
    <li><a href="stats_menquelles.php">📊 Statistiques</a></li>
    <li><a href="liste_rdv.php">📆 Rendez-vous</a></li>
    <li><a href="logout.php">🔓 Déconnexion</a></li>
  </ul>
</body>
</html>
