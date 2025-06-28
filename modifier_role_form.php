<?php
include 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role']!== 'admin') {
    exit("⛔ Accès refusé.");
}

$utilisateurs = $conn->query("SELECT id, nom, identifiant, rôle FROM utilisateurs");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gérer les rôles des utilisateurs</title>
  <style>
    body { font-family: sans-serif; background: #f5f6fa; padding: 40px;}
    table { border-collapse: collapse; width: 100%; background: white; box-shadow: 0 0 5px rgba(0,0,0,0.1);}
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left;}
    th { background: #0984e3; color: white;}
    form { display: flex; gap: 10px;}
    select, button { padding: 5px 10px;}
  </style>
</head>
<body>
  <h2>👥 Gérer les rôles des utilisateurs</h2>
  <a href="traiter_ajout_utilisateur.php">➕Ajouter un utilisateur</a>
  <table>
    <tr>
      <th>Nom</th>
      <th>Identifiant</th>
      <th>Rôle actuel</th>
      <th>Changer le rôle</th>
    </tr>
    <?php while ($u = $utilisateurs->fetch_assoc()):?>
 <tr>
        <td><?= htmlspecialchars($u['nom'])?></td>
        <td><?= htmlspecialchars($u['identifiant'])?></td>
        <td><?= htmlspecialchars($u['rôle'])?></td>
        <td>
          <form method="POST" action="modifier_role.php">
            <input type="hidden" name="id" value="<?= $u['id']?>">
            <select name="nouveau_role" required>
              <option value="">-- Choisir --</option>
              <option value="admin">admin</option>
              <option value="médecin">médecin</option>
              <option value="laborantin">laborantin</option>
            </select>
            <button type="submit">✅ Appliquer</button>
          </form>
        </td>
      </tr>
    <?php endwhile;?>
  </table>
</body>
</html>
