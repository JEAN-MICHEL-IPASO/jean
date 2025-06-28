<?php
include 'db.php';
session_start();

// Fonction pour calculer l'âge
function calculer_age($date_naiss) {
  if (!$date_naiss) return '?';
  $date = new DateTime($date_naiss);
  return $date->diff(new DateTime())->y;
}

// Récupération des patients ayant au moins une consultation
$patients = $conn->query("
  SELECT DISTINCT p.id, p.nom, p.date_consultation
  FROM patients p
  JOIN consultation c ON c.patient_id = p.id
  ORDER BY p.nom
");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Enregistrement d’un décès</title>
  <style>
    body { font-family: sans-serif; background: #f8f9fa; padding: 40px; max-width: 700px; margin: auto;}
    h2 { text-align: center; margin-bottom: 20px;}
    label { display: block; margin-top: 15px; font-weight: bold;}
    input, select, textarea { width: 100%; padding: 8px; margin-top: 5px;}
    button { margin-top: 20px; padding: 10px 20px; background: #2d3436; color: white; border: none; cursor: pointer;}
    button:hover { background: #0984e3;}
  </style>
</head>
<body>
<h2>💀 Enregistrement d’un décès</h2>
  <form action="enregistrer_deces.php" method="POST">

    <label for="patient_id">Patient:</label>
    <select name="patient_id" id="patient_id" required>
      <option value="">-- Sélectionner un patient --</option>
      <?php while ($p = $patients->fetch_assoc()):
        $age = calculer_age($p['date_naissance']);?>
        <option value="<?= $p['id']?>">#<?= $p['id']?> - <?= $p['nom']?> (<?= $age?> ans)</option>
      <?php endwhile;?>
    </select>

    <label>Provenance:</label>
    <input name="provenance" required>

    <label>Zone de santé:</label>
    <input name="zone_sante">

    <label>Aire de santé:</label>
    <input name="aire_sante">

    <label>Formation sanitaire:</label>
    <input name="formation">

    <label>Téléphone:</label>
    <input name="telephone">

    <label>Nom du médecin:</label>
    <input name="nom_medecin" required>

    <label>Société du médecin:</label>
    <input name="societe">

    <label>Matricule:</label>
    <input name="matricule">
<label>Date du décès:</label>
    <input type="date" name="date_deces" required>

    <label>Heure du décès:</label>
    <input type="time" name="heure_deces" required>

    <label>Motif du décès:</label>
    <textarea name="motif_deces" rows="3" required></textarea>

    <button type="submit">✅ Enregistrer le décès</button>
  </form>
</body>
</html>
