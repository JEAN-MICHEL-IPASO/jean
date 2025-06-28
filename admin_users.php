<?php
include 'db.php';
session_start();
if ($_SESSION['role']!== 'admin') exit("Accès réservé.");
$result = $conn->query("SELECT * FROM utilisateurs");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des utilisateurs</title>
  <style>
    table { width: 100%; border-collapse: collapse; background: white;}
    th, td { border: 1px solid #ccc; padding: 10px;}
    select { width: 100px;}
  </style>
</head>
<body>
  <h2>Utilisateurs</h2>
  <table>
    <tr><th>Nom</th><th>Identifiant</th><th>Rôle</th><th>Action</th></tr>
    <?php while ($u = $result->fetch_assoc()):?>
    <tr>
      <td><?= htmlspecialchars($u['nom'])?></td>
      <td><?= htmlspecialchars($u['identifiant'])?></td>
      <td><?= $u['rôle']?></td>
      <td>
        <form method="POST" action="modifier_role.php">
          <input type="hidden" name="id" value="<?= $u['id']?>">
          <select name="nouveau_role">
            <option value="admin">Admin</option>
            <option value="médecin">Médecin</option>
            <option value="laborantin">Laborantin</option>
          </select>
          <button type="submit">Modifier</button>
        </form>
      </td>
    </tr>
    <?php endwhile;?>
  </table>
</body>
</html>
