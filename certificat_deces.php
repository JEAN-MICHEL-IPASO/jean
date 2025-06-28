<?php
include 'db.php';
session_start();

// Fonction de calcul d’âge
function age($date_naiss) {
    if (!$date_naiss) return '—';
    $d = new DateTime($date_naiss);
    return $d->diff(new DateTime())->y;
}

// Vérification de l’ID
if (!isset($_GET['id'])) exit("Certificat introuvable.");
$id = intval($_GET['id']);

// Requête avec jointure pour récupérer nom et date de naissance
$res = $conn->query("
  SELECT cd.*, p.nom AS nom_patient, p.date_consultation
  FROM certificat_deces cd
  JOIN patients p ON cd.patient_id = p.id
  WHERE cd.id = $id
");

$certif = $res->fetch_assoc();
if (!$certif) exit("❌ Aucune donnée trouvée pour ce certificat.");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Certificat Officiel de Décès</title>
  <style>
    body { font-family: serif; max-width: 800px; margin: auto; padding: 60px; background: #fff;}
.cadre { border: 2px solid black; padding: 30px;}
.ligne { margin-bottom: 15px;}
.titre { font-weight: bold; display: inline-block; width: 200px;}
 h1 { text-align: center; text-transform: uppercase; margin-bottom: 30px;}
.signature { margin-top: 60px; text-align: right;}
.no-print { margin-top: 30px;}
    @media print {.no-print { display: none;}}
  </style>
</head>
<body>

  <div style="text-align:center; margin-bottom:30px;">
    <img src="5.png" alt="Logo établissement" style="height: 80px;">
    <h2 style="margin: 0;">RDC  Ministère de la Santé</h2>
    <h3><small><u>Centre de Santé MERE ET ENFANT</u></small></h3>
  </div>

  <h1>Certificat Officiel de Décès</h1>

  <div class="cadre">
    <div class="ligne"><span class="titre">Nom du patient:</span> <?= htmlspecialchars($certif['nom_patient'])?></div>
    <div class="ligne"><span class="titre">Âge:</span> <?= age($certif['date_consultation'])?> ans</div>
    <div class="ligne"><span class="titre">Date du décès:</span> <?= $certif['date_deces']?> à <?= $certif['heure_deces']?></div>
    <div class="ligne"><span class="titre">Motif du décès:</span> <?= nl2br(htmlspecialchars($certif['motif_deces']))?></div>
    <div class="ligne"><span class="titre">Provenance:</span> <?= htmlspecialchars($certif['provenance'])?></div>
    <div class="ligne"><span class="titre">Zone/Aire de santé:</span> <?= htmlspecialchars($certif['zone_sante'])?> / <?= htmlspecialchars($certif['aire_sante'])?></div>
    <div class="ligne"><span class="titre">Formation sanitaire:</span> <?= htmlspecialchars($certif['formation'])?></div>
    <div class="ligne"><span class="titre">Médecin:</span> Dr <?= htmlspecialchars($certif['nom_medecin'])?> (<?= htmlspecialchars($certif['societe'])?>)</div>
<div class="ligne"><span class="titre">Matricule:</span> <?= htmlspecialchars($certif['matricule'])?></div>

    <div class="signature">
      <div>Signature du médecin</div>
      <div style="margin-top:40px;">________________________</div>
    </div>
  </div>

  <div class="no-print">
    <button onclick="window.print()">🖨 Imprimer / Exporter PDF</button>
    <a href="liste_deces.php">⬅ Retour à la liste</a>
  </div>

</body>
</html>
