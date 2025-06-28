<?php
include 'db.php';
session_start();

$res = $conn->query("
  SELECT cd.id, p.nom, p.date_consultation, cd.date_deces, cd.motif_deces, cd.nom_medecin
  FROM certificat_deces cd
  JOIN patients p ON cd.patient_id = p.id
  ORDER BY cd.date_deces DESC
");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des décès</title>
  <style>
    body { font-family: sans-serif; padding: 40px; background: #f8f9fa;}
    h2 { margin-bottom: 20px;}
    input { padding: 8px; margin-bottom: 15px; width: 300px;}
    table { width: 100%; border-collapse: collapse; background: white;}
    th, td { padding: 10px; border: 1px solid #ccc;}
    th { background: #0984e3; color: white;}
    tr:hover { background: #f1f2f6;}
.btn { background: #636e72; color: white; padding: 6px 12px; border: none; text-decoration: none;}
.btn:hover { background: #2d3436;}
  </style>
</head>
<body>
  <h2>💀 Liste des certificats de décès</h2>

  <input type="text" id="search" placeholder="Rechercher un nom...">
 <table id="tableDeces">
    <thead>
      <tr>
        <th>Nom du patient</th>
        <th>Âge</th>
        <th>Date du décès</th>
        <th>Motif</th>
        <th>Médecin</th>
        <th>Certificat</th>
      </tr>
    </thead>
    <tbody>
      <?php
        function age($naiss) {
          return $naiss? (new DateTime($naiss))->diff(new DateTime())->y: '—';
}

        while ($d = $res->fetch_assoc()):
          $age = age($d['date_consultation']);
?>
        <tr>
          <td><?= htmlspecialchars($d['nom'])?></td>
          <td><?= $age?> ans</td>
          <td><?= $d['date_deces']?></td>
          <td><?= htmlspecialchars($d['motif_deces'])?></td>
          <td><?= htmlspecialchars($d['nom_medecin'])?></td>
          <td><a class="btn" href="certificat_deces.php?id=<?= $d['id']?>">Voir</a></td>
        </tr>
      <?php endwhile;?>
    </tbody>
  </table>
 <script>
    const input = document.getElementById('search');
    const rows = document.querySelectorAll('#tableDeces tbody tr');
    input.addEventListener('input', () => {
      const val = input.value.toLowerCase();
      rows.forEach(row => {
        const nom = row.cells[0].textContent.toLowerCase();
        row.style.display = nom.includes(val)? '': 'none';
});
});
  </script>

</body>
</html>

