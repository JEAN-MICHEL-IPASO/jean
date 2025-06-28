<?php
session_start();
$message = $_SESSION['message']?? '';
unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Créer un compte</title>
  <style>
    body { font-family: sans-serif; background: #ecf0f1; display: flex; justify-content: center; align-items: center; height: 100vh;}
    form { background: white; padding: 30px; border-radius: 10px; width: 320px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
    input, select, button { width: 100%; margin: 10px 0; padding: 10px;}
.alert { background: #ffe3e3; color: #b00020; padding: 10px; border-radius: 5px;}
  </style>
</head>
<body>
  <form action="traiter_inscription.php" method="POST">
    <h2>Créer un compte</h2>
    <?php if ($message):?>
      <div class="alert"><?= htmlspecialchars($message)?></div>
    <?php endif;?>
    <input name="nom" placeholder="Nom complet" required>
    <input name="identifiant" placeholder="Identifiant" required>
    <input name="mot_de_passe" type="password" placeholder="Mot de passe" required>
    <select name="rôle" required>
      <option value="">-- Choisir un rôle --</option>
      <option value="admin">Admin</option>
      <option value="médecin">Médecin</option>
      <option value="laborantin">Laborantin</option>
    </select>
  <button type="submit">Créer mon compte</button>
    <p style="text-align:center; font-size:0.9em;">
      Déjà inscrit? <a href="login.php">Se connecter</a>
    </p>
  </form>
</body>
</html>
