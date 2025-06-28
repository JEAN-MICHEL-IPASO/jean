<?php
include 'db.php';

// 1. Statistiques par acte (designation)
$acts = $conn->query("
  SELECT designation, COUNT(*) AS nombre, SUM(montant_global) AS total
  FROM facture
  GROUP BY designation
  ORDER BY nombre DESC
  LIMIT 5
");

// 2. Statistiques par patient
$patients = $conn->query("
  SELECT CONCAT( p.nom) AS nom_patient, SUM(f.montant_global) AS total
  FROM facture f
  JOIN patients p ON f.patient_id = p.id
  GROUP BY f.patient_id
  ORDER BY total DESC
  LIMIT 5
");

// Remplir les tableaux de données pour Chart.js
$labels_acts = $data_acts = [];
while ($row = $acts->fetch_assoc()) {
  $labels_acts[] = $row['designation'];
  $data_acts[] = $row['nombre'];
}

$labels_pat = $data_pat = [];
while ($row = $patients->fetch_assoc()) {
  $labels_pat[] = $row['nom_patient'];
  $data_pat[] = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Statistiques des factures</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: sans-serif; padding: 40px; max-width: 900px; margin: auto; background: #fefefe;}
    h2 { text-align: center; margin-bottom: 30px;}
    canvas { max-width: 100%; margin: 40px auto; display: block;}
  </style>
</head>
<body>

  <h2>📈 Statistiques des factures</h2>

  <h3>🔹 Actes les plus fréquents</h3>
  <canvas id="actesChart"></canvas>

  <h3>🔹 Patients les plus facturés</h3>
  <canvas id="patientsChart"></canvas>

  <script>
    const actesCtx = document.getElementById('actesChart').getContext('2d');
    new Chart(actesCtx, {
      type: 'bar',
      data: {
        labels: <?= json_encode($labels_acts)?>,
        datasets: [{
          label: 'Nombre d’actes',
          data: <?= json_encode($data_acts)?>,
          backgroundColor: '#0984e3'
}]
}
});

    const patientsCtx = document.getElementById('patientsChart').getContext('2d');
    new Chart(patientsCtx, {
      type: 'pie',
      data: {
        labels: <?= json_encode($labels_pat)?>,
        datasets: [{
          label: 'Montant global (FC)',
          data: <?= json_encode($data_pat)?>,
          backgroundColor: ['#6c5ce7','#00b894','#d63031','#e17055','#2d3436']
}]
}
});
  </script>

</body>
</html>
