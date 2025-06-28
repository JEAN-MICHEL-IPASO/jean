<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id']) || $_SESSION['role']!== 'laborantin') {
    exit("⛔ Accès refusé");
}

$nom = $_SESSION['nom']?? 'Laborantin';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Interface Laboratoire</title>
  <style>
nav{
  display: flex;
  justify-content: space-around;
  align-items: center;
  background-color: aqua;
  margin: 10px;
  height: 50px;
}
h2{
  text-align: center;
}
a{
  background-color: rgb(170, 215, 215);
  height: 40px;
  border-radius: 7px;
 border-style: double;
  border-color: rgb(147, 126, 126);
  transition: 3s;
}
a:hover{
  background-color: beige;
}
  </style>
</head>
<body>
  <h2>🧬 Bonjour <?= htmlspecialchars($nom)?> (Laboratoire)</h2>
  <nav>
    <a href="bon_labo.php">🧾 Bon de laboratoire</a>
    <a href="ajouter_examen.php">Ajouter un Examen</a>
    <a href="liste_rdv.php">📆 Rendez-vous</a>
    <a href="agenda_semaine.php">📅 Agenda</a>
    <a href="logout.php">🔓 Déconnexion</a>
  </nav>
</body>
</html>
