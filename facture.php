<?php
include 'db.php';
session_start();

if (!isset($_GET['id'])) exit("⛔ Facture introuvable.");
$id = intval($_GET['id']);

// Récupère la facture + données patient
$res = $conn->query("
  SELECT f.*, p.nom, p.adresse, p.telephone
  FROM facture f
  JOIN patients p ON f.patient_id = p.id
  WHERE f.id = $id
");
$facture = $res->fetch_assoc();
if (!$facture) exit("❌ Aucune facture trouvée.");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Facture n° <?= htmlspecialchars($facture['numero_facture'])?></title>
  <style>
    body { font-family: serif; padding: 60px; max-width: 800px; margin: auto; background: #fff;}
.entete { text-align: center; margin-bottom: 30px;}
.entete img { height: 80px;}
    h1 { text-align: center; margin-bottom: 20px;}
.cadre { border: 2px solid black; padding: 30px;}
.ligne { margin-bottom: 12px;}
.titre { font-weight: bold; display: inline-block; width: 200px;}
.signature { margin-top: 60px; text-align: right;}
.no-print { margin-top: 30px;}
    @media print {.no-print { display: none;}}
  </style>
</head>
<body>

  <div class="entete">
    <img src="2.png" alt="Logo établissement">
    <h2>Centre de Santé MERE ET ENFANT</h2>
    <small>Facturation officielle</small>
  </div>

  <h1>Facture N° <?= htmlspecialchars($facture['numero_facture'])?></h1>

  <div class="cadre">
    <div class="ligne"><span class="titre">Patient:</span> <?= htmlspecialchars($facture['nom'])?></div>
    <div class="ligne"><span class="titre">Adresse:</span> <?= htmlspecialchars($facture['adresse'])?></div>
    <div class="ligne"><span class="titre">Téléphone:</span> <?= htmlspecialchars($facture['telephone'])?></div>
    <div class="ligne"><span class="titre">Date:</span> <?= htmlspecialchars($facture['date'])?></div>
    <div class="ligne"><span class="titre">Désignation:</span> <?= htmlspecialchars($facture['designation'])?></div>
    <div class="ligne"><span class="titre">Quantité:</span> <?= htmlspecialchars($facture['quantite'])?></div>
    <div class="ligne"><span class="titre">Prix unitaire:</span> <?= number_format($facture['prix_unitaire'], 2, ',', ' ')?> FC</div>
    <div class="ligne"><span class="titre">Prix total:</span> <?= number_format($facture['prix_total'], 2, ',', ' ')?> FC</div>
    <div class="ligne"><span class="titre">Montant global:</span> <?= number_format($facture['montant_global'], 2, ',', ' ')?> FC</div>

    <div class="signature">
      <div>Signature du comptable</div>
      <div style="margin-top: 40px;">__________________________</div>
    </div>
  </div>
<div class="no-print">
    <button onclick="window.print()">🖨 Imprimer / Exporter PDF</button>
    <a href="dashboard_factures.php">⬅ Retour</a>
  </div>

</body>
</html>
