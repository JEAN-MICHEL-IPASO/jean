<?php
include 'db.php';
session_start();

$filtre_nom = $_GET['nom']?? '';
$filtre_mois = $_GET['mois']?? date('Y-m');
$like_nom = "%$filtre_nom%";

$stmt = $conn->prepare("
  SELECT f.*, p.nom
  FROM facture f
  JOIN patients p ON f.patient_id = p.id
  WHERE p.nom LIKE?
    AND DATE_FORMAT(f.date, '%Y-%m') =?
  ORDER BY f.date DESC
");

$stmt->bind_param("ss", $like_nom, $filtre_mois);
$stmt->execute();
$factures = $stmt->get_result();
$total_mois = 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Suivi des factures patients</title>
  <style>
    body { font-family: sans-serif; padding: 40px; max-width: 1000px; margin: auto; background: #f4f4f4;}
    h2 { text-align: center; margin-bottom: 20px;}
.filters { display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px;}
.filters input,.filters select { padding: 6px; flex: 1; min-width: 200px;}
    table { width: 100%; border-collapse: collapse; background: white;}
    th, td { padding: 10px; border: 1px solid #ddd;}
th { background: #f0f0f0;}
.total { text-align: right; margin-top: 15px; font-weight: bold;}
    a.btn { padding: 8px 12px; background: #2d3436; color: white; text-decoration: none; border-radius: 5px;}
.actions { display: flex; gap: 10px;}
  </style>
</head>
<body>

  <h2>📋 Tableau de bord des factures</h2>

  <form method="get" class="filters">
    <input type="text" name="nom" placeholder="Nom du patient" value="<?= htmlspecialchars($filtre_nom)?>">
    <input type="month" name="mois" value="<?= htmlspecialchars($filtre_mois)?>">
    <button type="submit">🔍 Filtrer</button>
    <a href="ajouter_facture.php" class="btn">➕ Nouvelle facture</a>
    <a href="statistiques_factures.php" class="btn">VOIR STAT-FACTURES</a>
  </form>

  <table>
    <tr>
      <th>Date</th>
      <th>Patient</th>
      <th>N° Facture</th>
      <th>Acte</th>
      <th>Quantité</th>
      <th>Total (FC)</th>
      <th>Actions</th>
    </tr>
    <?php while($f = $factures->fetch_assoc()):
      $total_mois += $f['montant_global'];?>
      <tr>
        <td><?= $f['date']?></td>
        <td><?= htmlspecialchars($f['nom'])?></td>
        <td><?= htmlspecialchars($f['numero_facture'])?></td>
        <td><?= htmlspecialchars($f['designation'])?></td>
 <td><?= $f['quantite']?></td>
        <td><?= number_format($f['montant_global'], 0, ',', ' ')?></td>
        <td class="actions">
          <a href="facture.php?id=<?= $f['id']?>" target="_blank">📄 Voir</a>
        </td>
      </tr>
    <?php endwhile;?>
  </table>

  <div class="total">💰 Total facturé pour <?= date('F Y', strtotime($filtre_mois. '-01'))?>: <?= number_format($total_mois, 0, ',', ' ')?> FC</div>

</body>
</html>

