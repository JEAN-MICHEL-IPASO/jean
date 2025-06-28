<!DOCTYPE html>
<html lang="fr">
<head>	
  <meta charset="UTF-8">
  <title>Ordonnance Médicale</title>
  <style>
    body { font-family: sans-serif; background: #f1f1f1; padding: 20px;}
    form { background: #fff; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto;}
    input, textarea { width: 100%; padding: 10px; margin-top: 10px;}
    button { margin-top: 15px; padding: 10px 20px; background: #17a2b8; color: white; border: none;}
  </style>
</head>
<body>
  <h2>Ordonnance Médicale</h2>
  <form action="enregistrer_ordonnance.php" method="POST">
    <label>Nom du patient</label>
    <input type="text" name="nom" required>
    <label>Âge</label>
    <input type="number" name="age" required>
    <label>Sexe</label>
    <select name="sexe"><option>Masculin</option><option>Féminin</option></select>
    <label>Date</label>
    <input type="date" name="date" required>
    <label>Médicaments prescrits</label>
    <textarea name="medicaments" rows="5" required></textarea>
    <button type="submit">Enregistrer l’ordonnance</button>
  </form>
</body>
</html>
