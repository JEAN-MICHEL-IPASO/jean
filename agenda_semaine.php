<?php
include 'db.php';
session_start();

// Début et fin de la semaine en cours
$debut = date('Y-m-d', strtotime('monday this week'));
$fin   = date('Y-m-d', strtotime('sunday this week'));

// Requête pour récupérer les rendez-vous de la semaine
$sql = "
  SELECT r.date_rdv, r.heure, p.nom, r.motif, r.statut
  FROM rendez_vous r
  JOIN patients p ON r.patient_id = p.id
  WHERE r.date_rdv BETWEEN? AND?
  ORDER BY r.date_rdv ASC, r.heure ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $debut, $fin);
$stmt->execute();
$requete = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Agenda de la semaine</title>
  <style>
    body { font-family: sans-serif; padding: 40px; max-width: 1000px; margin: auto; background: #f4f6f7;}
    h2 { text-align: center; margin-bottom: 30px;}
    table { width: 100%; border-collapse: collapse; background: white;}
    th, td { padding: 10px; border: 1px solid #ccc; text-align: left;}
    th { background: #ecf0f1;}
.Prévu { color: #3498db; font-weight: bold;}
.Effectué { color: #27ae60; font-weight: bold;}
.Annulé { color: #c0392b; font-weight: bold;}
  </style>
</head>
<body>
<h2>🗓 Agenda de la semaine du <?= date('d/m', strtotime($debut))?> au <?= date('d/m/Y', strtotime($fin))?></h2>

  <table>
    <tr>
      <th>Date</th>
      <th>Heure</th>
      <th>Patient</th>
      <th>Motif</th>
      <th>Statut</th>
    </tr>
    <?php while ($row = $requete->fetch_assoc()):?>
      <tr>
        <td><?= date('d/m/Y', strtotime($row['date_rdv']))?></td>
        <td><?= substr($row['heure'], 0, 5)?></td>
        <td><?= htmlspecialchars($row['nom'])?></td>
        <td><?= htmlspecialchars($row['motif'])?></td>
        <td class="<?= $row['statut']?>"><?= $row['statut']?></td>
      </tr>
    <?php endwhile;?>
  </table>

</body>
</html>
