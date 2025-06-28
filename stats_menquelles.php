<?php
include 'db.php';
// Valeurs globales pour les compteurs
$total_consult = $conn->query("SELECT COUNT(*) FROM patients WHERE date_consultation IS NOT NULL")->fetch_row()[0];
$total_deces = $conn->query("SELECT COUNT(*) FROM certificat_deces")->fetch_row()[0];
$total_users = $conn->query("SELECT COUNT(*) FROM utilisateurs")->fetch_row()[0];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Statistiques annuelles</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: sans-serif; background: #f5f6fa; padding: 40px;}
.cards { display: flex; gap: 20px; margin-bottom: 40px;}
.card { background: white; flex: 1; padding: 20px; border-radius: 10px; box-shadow: 0 0 8px rgba(0,0,0,0.1); text-align: center;}
    h2 { margin-bottom: 5px; color: #2d3436;}
    select, button { margin-top: 10px; padding: 8px 12px;}
    canvas { background: white; padding: 20px; border-radius: 10px; max-width: 700px; margin-top: 40px; box-shadow: 0 0 8px rgba(0,0,0,0.1);}
  </style>
</head>
<body>
  <h1>📊 Statistiques annuelles</h1>

<div class="cards">
    <div class="card"><h2><?= $total_consult?></h2><p>Consultations</p></div>
    <div class="card"><h2><?= $total_deces?></h2><p>Cas de décès</p></div>
    <div class="card"><h2><?= $total_users?></h2><p>Utilisateurs</p></div>
  </div>

  <form id="choix-annee">
    <label for="annee">Sélectionnez une année:</label>
    <select id="annee" name="annee">
      <?php
        $currentYear = date("Y");
        for ($y = $currentYear; $y>= $currentYear - 5; $y--) {
          echo "<option value='$y'>$y</option>";
}
?>
    </select>
    <button type="submit">Afficher</button>
    <button onclick="window.print(); return false;">🖨 Imprimer</button>
  </form>

  <canvas id="statChart" width="700" height="400"></canvas>

  <script>
    function chargerStats(annee) {
      fetch('stat_mois.php?annee=' + annee)
.then(res => res.json())
.then(data => {
          const ctx = document.getElementById('statChart').getContext('2d');
          if (window.chartInstance) window.chartInstance.destroy(); // reset
 window.chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: data.labels,
              datasets: [{
                label: 'Consultations/mois',
                data: data.values,
                backgroundColor: '#00b894'
}]
},
            options: {
              responsive: true,
              scales: {
                y: { beginAtZero: true},
                x: { title: { display: true, text: "Mois"}}
}
}
});
});
}

    // Affiche dès le chargement
    const anneeSelect = document.getElementById('annee');
    chargerStats(anneeSelect.value);

    document.getElementById('choix-annee').addEventListener('submit', function(e) {
      e.preventDefault();
      chargerStats(anneeSelect.value);
});
  </script>
</body>
</html>
