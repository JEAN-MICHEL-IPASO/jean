<?php
include 'db.php';
session_start();

// Filtres
$filtre_nom    = $_GET['nom']?? '';
$filtre_date   = $_GET['date']?? '';
$filtre_statut = $_GET['statut']?? '';

$like_nom    = "%$filtre_nom%";
$like_date   = $filtre_date?: '%';
$like_statut = $filtre_statut?: '%';

// Préparation de la requête avec jointure sur patients
$stmt = $conn->prepare("
  SELECT r.*, p.nom AS nom_patient
  FROM rendez_vous r
  JOIN patients p ON r.patient_id = p.id
  WHERE p.nom LIKE?
    AND r.date_rdv LIKE?
    AND r.statut LIKE?
  ORDER BY r.date_rdv DESC, r.heure ASC
");
$stmt->bind_param("sss", $like_nom, $like_date, $like_statut);
$stmt->execute();
$result = $stmt->get_result();

$rdvs_data = [];
while ($row = $result->fetch_assoc()) {
  $rdvs_data[] = $row;
}

// Statistiques
$effectues = $annules = $prevus = 0;
foreach ($rdvs_data as $r) {
  switch ($r['statut']) {
    case 'Effectué': $effectues++; break;
    case 'Annulé': $annules++; break;
    case 'Prévu': $prevus++; break;
}
}
$total = $effectues + $annules + $prevus;
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des rendez-vous</title>
 <style>
     body {
      font-family: Arial, sans-serif;
      background:rgb(46, 82, 96);
      padding: 30px;
}
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      margin-bottom: 40px;
}
    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: left;
}
    th {
      background-color: #007bff;
      color: white;
}
.stats-container {
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      max-width: 600px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.stat {
      margin: 20px 0;
      font-size: 1.2rem;
}
.bar {
      height: 10px;
      margin-top: 5px;
      border-radius: 5px;
      background: var(--color, #ccc);
      width: var(--value, 0%);
      transition: width 1s ease;
}
a{
  color: blue;
}
.btne{
  color: white;
  font: 1em sans-serif;
  align-item: left;
}

  </style>
</head>
<body>

  <h2>📆 Liste des rendez-vous</h2>

  <form method="get">
    <input type="text" name="nom" placeholder="Nom du patient" value="<?= htmlspecialchars($filtre_nom)?>">
    <input type="date" name="date" value="<?= htmlspecialchars($filtre_date)?>">
    <select name="statut">
      <option value="">-- Tous les statuts --</option>
      <option value="Prévu" <?= $filtre_statut === 'Prévu'? 'selected': ''?>>Prévu</option>
      <option value="Effectué" <?= $filtre_statut === 'Effectué'? 'selected': ''?>>Effectué</option>
      <option value="Annulé" <?= $filtre_statut === 'Annulé'? 'selected': ''?>>Annulé</option>
    </select>
    <button type="submit">🔍 Filtrer</button>
    <a href="ajouter_rdv.php" class="btne">➕ Nouveau rendez-vous</a>
  </form>

<table>
    <tr>
      <th>Date</th>
      <th>Heure</th>
      <th>Patient</th>
      <th>Motif</th>
      <th>Statut</th>
      <th>Commentaire</th>
      <th>Actions</th>
    </tr>
    <?php foreach ($rdvs_data as $r):?>
    <tr>
      <td><?= $r['date_rdv']?></td>
      <td><?= substr($r['heure'], 0, 5)?></td>
      <td><?= htmlspecialchars($r['nom_patient'])?></td>
      <td><?= htmlspecialchars($r['motif'])?></td>
      <td class="statut <?= $r['statut']?>"><?= $r['statut']?></td>
      <td><?= nl2br(htmlspecialchars($r['commentaire']))?></td>
      <td class="actions">
        <a href="modifier_rdv.php?id=<?= $r['id']?>" class="btn">✏ Modifier</a>
        <?php if ($r['statut']!== 'Effectué'):?>
          <a href="changer_statut.php?id=<?= $r['id']?>&statut=Effectué" class="btn">✅ Effectué</a>
        <?php endif;?>
        <?php if ($r['statut']!== 'Annulé'):?>
          <a href="changer_statut.php?id=<?= $r['id']?>&statut=Annulé" class="btn">❌ Annuler</a>
        <?php endif;?>
      </td>
    </tr>
    <?php endforeach;?>
  </table>

  <div class="stats-container">
    <h2>📊 Statistiques des rendez-vous</h2>

    <div class="stat">
      ✅ Effectués: <span class="count" data-count="<?= $effectues?>" style="color: #27ae60;">0</span>
      <div class="bar" style="--value: <?= round($effectues * 100 / max($total, 1), 1)?>%; background-color: #27ae60;"></div>
    </div>

    <div class="stat">
      ❌ Annulés: <span class="count" data-count="<?= $annules?>" style="color: #e74c3c;">0</span>
      <div class="bar" style="--value: <?= round($annules * 100 / max($total, 1), 1)?>%; background-color: #e74c3c;"></div>
    </div>

    <div class="stat">
      ⏳ Prévu: <span class="count" data-count="<?= $prevus?>" style="color: #f39c12;">0</span>
      <div class="bar" style="--value: <?= round($prevus * 100 / max($total, 1), 1)?>%; background-color: #f39c12;"></div>
    </div>

    <canvas id="donut" width="200" height="200" style="margin-top: 30px;"></canvas>
  </div>

  <script>
    // Animation de comptage
    document.querySelectorAll('.count').forEach(span => {
      const target = +span.dataset.count;
      let count = 0;
      const step = Math.max(1, Math.ceil(target / 40));
      function update() {
        count += step;
        if (count>= target) {
 span.textContent = target;
} else {
          span.textContent = count;
          requestAnimationFrame(update);
}
}
      update();
});

    // Graphique donut
    const ctx = document.getElementById('donut').getContext('2d');
    new Chart(ctx, {
      type: 'doughnut',
      data: {labels: ['Effectués', 'Annulés', 'Prévu'],
        datasets: [{
          data: [<?= $effectues?>, <?= $annules?>, <?= $prevus?>],
          backgroundColor: ['#27ae60', '#e74c3c', '#f39c12'],
}]
},
      options: {
        plugins: {
          legend: { position: 'bottom'}
}
}
});
  </script>

 


 
</body>
</html>
