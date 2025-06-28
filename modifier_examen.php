<?php
include 'db.php';
session_start();

if (!isset($_GET['id'])) exit("Identifiant manquant.");
$id = intval($_GET['id']);

// Récupérer les données de l’examen
$stmt = $conn->prepare("
  SELECT e.*, p.nom
  FROM examens e
  JOIN patients p ON e.patient_id = p.id
  WHERE e.id =?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$examen = $stmt->get_result()->fetch_assoc();

if (!$examen) exit("Examen introuvable.");

$statuts = ['En attente', 'Validé', 'Rejeté'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier un examen</title>
  <style>
    body { font-family: sans-serif; padding: 40px; max-width: 600px; margin: auto; background: #f5f7f9;}
    label { display: block; margin-top: 15px; font-weight: bold;}
    input, textarea, select { width: 100%; padding: 8px; margin-top: 5px;}
    button { margin-top: 20px; padding: 10px 20px; background: #2d3436; color: white; border: none; cursor: pointer;}
    button:hover { background: #0984e3;}
  </style>
</head>
<body>

<h2>✏ Modifier l’examen de <?= htmlspecialchars($examen['nom'])?></h2>

  <form action="enregistrer_modif_examen.php" method="POST">
    <input type="hidden" name="id" value="<?= $examen['id']?>">

    <label>Date:</label>
    <input type="date" name="date" value="<?= $examen['date']?>" required>

    <label>Type d’examen:</label>
    <input type="text" name="type" value="<?= htmlspecialchars($examen['type'])?>" required>

    <label>Résultat:</label>
    <textarea name="resultat" rows="3"><?= htmlspecialchars($examen['resultat'])?></textarea>

    <label>Statut:</label>
    <select name="statut" required>
      <?php foreach ($statuts as $s):?>
        <option value="<?= $s?>" <?= $examen['statut'] === $s? 'selected': ''?>><?= $s?></option>
      <?php endforeach;?>
    </select>

    <button type="submit">💾 Enregistrer les modifications</button>
  </form>

</body>
</html>

