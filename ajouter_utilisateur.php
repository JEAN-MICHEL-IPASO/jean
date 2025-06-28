<?php
session_start();
$message = $_SESSION['message']?? '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un utilisateur</title>
  <style>
    body { font-family: sans-serif; background: #f0f2f5; padding: 40px;}
    form { background: white; padding: 30px; border-radius: 8px; width: 400px; margin: auto; box-shadow: 0 0 8px rgba(0,0,0,0.1);}
    input, select, button { width: 100%; margin: 10px 0; padding: 10px;}
.alert { background: #ffe3e3; color: #b00020; padding: 10px; border-radius: 5px;}
.success { background: #dfe6e9; color: #2d3436; padding: 10px; border-radius: 5px;}
  </style>
</head>
<body>
  <form action="traiter_ajout_utilisateur.php" method="POST">
    <h2>➕ Ajouter un utilisateur</h2>
    <?php if ($message):?>
      <div class="<?= str_starts_with($message, '✅')? 'success': 'alert'?>">
        <?= htmlspecialchars($message)?>
      </div>
    <?php endif;?>
    <input type="text" name="nom" placeholder="Nom complet" required>
    <input type="text" name="identifiant" placeholder="Identifiant (ex: jdupont)" required>
    <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
    <select name="role" required>
<option value="">-- Sélectionner un rôle --</option>
      <option value="admin">Administrateur</option>
      <option value="médecin">Médecin</option>
      <option value="laborantin">Laborantin</option>
    </select>
    <button type="submit">Créer l'utilisateur</button>
    <p style="text-align:center; font-size:0.9em; margin-top:15px;">
      <a href="admin_dashboard.php">⬅ Retour au tableau de bord</a>
    </p>
  </form>
</body>
</html>
