<?php
include 'db.php';
$filtre_date  = $_GET['jour']?? '';
$filtre_mois  = $_GET['mois']?? '';
$filtre_annee = $_GET['annee']?? '';

$conditions = [];
$params = [];
$types = '';

// Construction dynamique de la requête
if (!empty($filtre_date)) {
  $conditions[] = "DATE(f.date) =?";
  $params[] = $filtre_date;
  $types.= 's';
  $periode_libelle = "le ". date('d/m/Y', strtotime($filtre_date));
} elseif (!empty($filtre_mois)) {
  $conditions[] = "DATE_FORMAT(f.date, '%Y-%m') =?";
  $params[] = $filtre_mois;
  $types.= 's';
  $periode_libelle = "le mois de ". date('F Y', strtotime($filtre_mois. '-01'));
} elseif (!empty($filtre_annee)) {
  $conditions[] = "YEAR(f.date) =?";
  $params[] = $filtre_annee;
  $types.= 's';
  $periode_libelle = "l'année $filtre_annee";
} else {
  // Semaine en cours
  $debut = date('Y-m-d', strtotime('monday this week'));
  $fin   = date('Y-m-d', strtotime('sunday this week'));
  $conditions[] = "f.date BETWEEN? AND?";
  $params[] = $debut;
  $params[] = $fin;
  $types.= 'ss';
  $periode_libelle = "la semaine du ". date('d/m', strtotime($debut)). " au ". date('d/m/Y', strtotime($fin));
}

$sql = "
  SELECT p.nom, f.date, f.designation, f.quantite
  FROM facture f
  JOIN patients p ON f.patient_id = p.id
  WHERE ". implode(' AND ', $conditions). "
  ORDER BY f.date ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types,...$params);
$stmt->execute();
$donnees = $stmt->get_result();
$nb_total = $donnees->num_rows;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Rapport des consultations</title>
  <style>
    body { font-family: serif; padding: 40px; max-width: 900px; margin: auto;}
    h2, h3 { text-align: center; margin-bottom: 20px;}
    form { display: flex; gap: 15px; flex-wrap: wrap; margin-bottom: 30px; justify-content: center;}
    form input { padding: 6px;}
    table { width: 100%; border-collapse: collapse; margin-top: 10px;}
    th, td { padding: 8px; border: 1px solid #ccc; text-align: left;}
    th { background: #f0f0f0;}
.section { margin-top: 30px;}
.signature { margin-top: 60px; text-align: right;}
.no-print { margin-top: 30px; text-align: center;}
    @media print {.no-print { display: none;}}
  </style>
</head>
<body>

<h2>📋 Rapport des consultations</h2>

<form method="get">
  <div>
    <label>📅 Jour:</label><br>
    <input type="date" name="jour" value="<?= htmlspecialchars($filtre_date)?>">
  </div>
  <div>
    <label>🗓 Mois:</label><br>
    <input type="month" name="mois" value="<?= htmlspecialchars($filtre_mois)?>">
  </div>
  <div>
    <label>📆 Année:</label><br>
    <input type="number" name="annee" placeholder="2025" min="2000" max="2099" value="<?= htmlspecialchars($filtre_annee)?>">
  </div>
<div style="align-self:flex-end;">
    <button type="submit">🔍 Appliquer</button>
  </div>
</form>

<h3>📆 Période: <?= $periode_libelle?></h3>

<table>
  <tr>
    <th>Nom du patient</th>
    <th>Date</th>
    <th>Acte / Motif</th>
    <th>Quantité</th>
  </tr>
  <?php while($row = $donnees->fetch_assoc()):?>
  <tr>
    <td><?= htmlspecialchars($row['nom'])?></td>
    <td><?= $row['date']?></td>
    <td><?= htmlspecialchars($row['designation'])?></td>
    <td><?= $row['quantite']?></td>
  </tr>
  <?php endwhile;?>
</table>

<div class="section">
  <strong>✅ Total consultations:</strong> <?= $nb_total?>
</div>

<div class="section">
  <strong>Observations:</strong><br>
.......................................................................................................................<br>.......................................................................................................................
</div>

<div class="signature">
  <div>Fait à _______________________</div>
  <div>Le <?= date('d/m/Y')?></div>
  <br><br>
  <div>Signature du responsable</div>
  <div style="margin-top: 40px;">_________________________________</div>
</div>

<div class="no-print">
  <button onclick="window.print()">🖨 Imprimer / Exporter PDF</button>
</div>

</body>
</html>
