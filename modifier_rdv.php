<?php
include 'db.php';
session_start();

if (!isset($_GET['id'])) exit("Identifiant de rendez-vous manquant.");
$id = intval($_GET['id']);

// Charger les données du rendez-vous
$stmt = $conn->prepare("
  SELECT r.*, p.nom
  FROM rendez_vous r
  JOIN patients p ON r.patient_id = p.id
  WHERE r.id =?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$rdv = $stmt->get_result()->fetch_assoc();

if (!$rdv) exit("Aucun rendez-vous trouvé avec cet identifiant.");

// Pour la liste des statuts
$statuts = ['Prévu', 'Effectué', 'Annulé'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier un rendez-vous</title>
  <style>
    body { font-family: sans-serif; padding: 40px; max-width: 700px; margin: auto; background: #f0f0f0;}
    h2 { text-align: center; margin-bottom: 25px;}
    label { display: block; margin-top: 15px; font-weight: bold;}
    input, select, textarea { width: 100%; padding: 8px; margin-top: 5px;}
    button { margin-top: 20px; padding: 10px 20px; background: #2d3436; color: white; border: none; cursor: pointer;}
    button:hover { background: #0984e3;}
  </style>
</head>
<body>

  <h2>✏ Modifier le rendez-vous du patient: <?= htmlspecialchars($rdv['nom'])?></h2>

  <form action="enregistrer_modif_rdv.php" method="POST">
    <input type="hidden" name="id" value="<?= $rdv['id']?>">

    <label for="date_rdv">Date:</label>
    <input type="date" name="date_rdv" value="<?= $rdv['date_rdv']?>" required>

    <label for="heure">Heure:</label>
    <input type="time" name="heure" value="<?= substr($rdv['heure'], 0, 5)?>" required>

    <label for="motif">Motif:</label>
    <input type="text" name="motif" value="<?= htmlspecialchars($rdv['motif'])?>" required>

    <label for="statut">Statut:</label>
    <select name="statut" required>
      <?php foreach ($statuts as $statut):?>
        <option value="<?= $statut?>" <?= $rdv['statut'] === $statut? 'selected': ''?>><?= $statut?></option>
      <?php endforeach;?>
    </select>

    <label for="commentaire">Commentaire:</label>
    <textarea name="commentaire" rows="3"><?= htmlspecialchars($rdv['commentaire'])?></textarea>

    <button type="submit">💾 Enregistrer les modifications</button>
  </form>

</body>
</html>
