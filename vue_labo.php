<?php
include 'db.php';
session_start();

// Filtres
$filtre_date   = $_GET['date']?? '';
$filtre_type   = $_GET['type']?? '';
$filtre_statut = $_GET['statut']?? '';

// Requête principale
$like_date   = $filtre_date?: '%';
$like_type   = "%$filtre_type%";
$like_statut = $filtre_statut?: '%';

$stmt = $conn->prepare("
  SELECT e.*, p.nom AS patient_nom
  FROM examens e
  JOIN patients p ON e.patient_id = p.id
  WHERE e.date LIKE?
    AND e.type LIKE?
    AND e.statut LIKE?
  ORDER BY e.date DESC
");
$stmt->bind_param("sss", $like_date, $like_type, $like_statut);
$stmt->execute();
$res = $stmt->get_result();
$examens = [];
while($row = $res->fetch_assoc()) {
  $examens[] = $row;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Vue Laboratoire</title>
  <style>
    body { font-family: sans-serif; padding: 30px; max-width: 1000px; margin: auto; background: #f4f6f7;}
    h2 { text-align: center; margin-bottom: 25px;}
form { display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;}
    input, select { padding: 6px; min-width: 180px;}
    table { width: 100%; border-collapse: collapse; background: white;}
    th, td { padding: 10px; border: 1px solid #ccc; text-align: left;}
    th { background: #ecf0f1;}
.Validé { color: #27ae60; font-weight: bold;}
.En_attente { color: #f39c12; font-weight: bold;}
.Rejeté { color: #c0392b; font-weight: bold;}
  </style>
</head>
<body>

  <h2>🧪 Suivi des examens de laboratoire</h2>

  <form method="get">
    <input type="date" name="date" value="<?= htmlspecialchars($filtre_date)?>">
    <input type="text" name="type" placeholder="Type d’examen" value="<?= htmlspecialchars($filtre_type)?>">
    <select name="statut">
      <option value="">Tous les statuts</option>
      <option value="En attente" <?= $filtre_statut === 'En attente'? 'selected': ''?>>En attente</option>
      <option value="Validé" <?= $filtre_statut === 'Validé'? 'selected': ''?>>Validé</option>
      <option value="Rejeté" <?= $filtre_statut === 'Rejeté'? 'selected': ''?>>Rejeté</option>
    </select>
    <button type="submit">🔍 Filtrer</button>
  </form>
<button onclick="imprimerListe()" style="margin-bottom: 20px; padding: 10px 15px; background: #27ae60; color: white; border: none; border-radius: 4px; font-size: 14px;">
  🖨 Imprimer les examens
</button>


  <table>
    <tr>
      <th>Date</th>
      <th>Patient</th>
      <th>Type d’examen</th>
      <th>Résultat</th>
      <th>Statut</th>
    </tr>
 <?php foreach ($examens as $e):?>
    <tr>
      <td><?= $e['date']?></td>
      <td><?= htmlspecialchars($e['patient_nom'])?></td>
      <td><?= htmlspecialchars($e['type'])?></td>
      <td><?= htmlspecialchars($e['resultat'])?></td>
      <td class="<?= str_replace(' ', '_', $e['statut'])?>"><?= $e['statut']?></td>
    </tr>
    <?php endforeach;?>
  </table>
<script>
function imprimerListe() {
  const zone = document.querySelector('table'); // ou une div spécifique si besoin
  const fenetre = window.open('', '', 'height=700,width=900');
  fenetre.document.write('<html><head><title>Impression Examens</title>');
  fenetre.document.write('<style>body{font-family:sans-serif;} table{width:100%; border-collapse:collapse;} th,td{border:1px solid #ccc; padding:8px;} th{background:#eee;}</style>');
  fenetre.document.write('</head><body>');
  fenetre.document.write('<h2 style="text-align:center">🧪 Liste des examens de laboratoire</h2>');
  fenetre.document.write(zone.outerHTML);
  fenetre.document.write('</body></html>');
  fenetre.document.close();
  fenetre.focus();
  fenetre.print();
  fenetre.close();
}
</script>

</body>
</html>
