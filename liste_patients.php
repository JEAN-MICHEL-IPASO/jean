<?php
include 'db.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$patients = $conn->query("SELECT id, nom, sexe, date_consultation FROM patients ORDER BY nom");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des patients</title>
  <style>
    body { font-family: sans-serif; background:rgb(154, 110, 163); padding: 40px;}
    h2 { color: #2d3436;}
.actions { margin-bottom: 20px;}
    table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 0 5px rgba(0,0,0,0.1);}
    th, td { padding: 12px; border-bottom: 1px solid #ccc;}
    th { background: #0984e3; color: white; text-align: left;}
    tr:hover { background-color: #f1f2f6;}
.btn { padding: 8px 12px; background: #636e72; color: white; border: none; text-decoration: none;}
.search-input { padding: 8px; width: 250px;}
    @media print {
.actions,.btn { display: none;}
}
  </style>
</head>
<body>
 <h2>👤 Liste des patients</h2>

  <div class="actions">
    🔎 <input type="text" id="search" class="search-input" placeholder="Rechercher un nom...">
    <button onclick="window.print()" class="btn">🖨 Imprimer</button>
    <a href="admin_dashboard.php" class="btn">⬅ Retour</a>
  </div>

  <table id="tablePatients">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Sexe</th>
        <th>Date de consultation</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $patients->fetch_assoc()):?>
        <tr>
          <td><?= htmlspecialchars($row['nom'])?></td>
          <td><?= ucfirst($row['sexe'])?></td>
          <td><?= $row['date_consultation']?? '—'?></td>
        </tr>
      <?php endwhile;?>
    </tbody>
  </table>

  <script>
    const searchInput = document.getElementById('search');
    const rows = document.querySelectorAll('#tablePatients tbody tr');

searchInput.addEventListener('input', () => {
      const value = searchInput.value.toLowerCase();
      rows.forEach(row => {
        const nom = row.cells[0].textContent.toLowerCase();
        row.style.display = nom.includes(value)? '': 'none';
});
});
  </script>
</body>
</html>
