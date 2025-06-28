<!DOCTYPE html>
<html lang="fr">
<head>	
  <meta charset="UTF-8">
  <title>Fiche de consultation</title>
  <style>
    body { font-family: Arial; background: #f5f5f5; padding: 20px;}
    form { background: #fff; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto;}
    input, textarea, select { width: 100%; padding: 8px; margin-top: 10px;}
    button { margin-top: 15px; padding: 10px 20px; background: #28a745; color: #fff; border: none;}
  </style>
</head>
<body>
  <h2>Fiche de consultation</h2>
  <form action="enregistrer_consultation.php" method="POST">
    <label>Nom du patient</label>
    <input type="text" name="nom" required>
    <label>Âge</label>
    <input type="number" name="age" required>
    <label>Sexe</label>
    <select name="sexe"><option>Masculin</option><option>Féminin</option></select>
    <label>Adresse</label>
    <input type="text" name="adresse">
    <label>Nom du responsable</label>
    <input type="text" name="responsable">
    <label>Date</label>
    <input type="date" name="date_consultation">
    <label>Provenance</label>
    <input type="text" name="provenance">
    <label>Aire de santé</label>
    <input type="text" name="aire_sante">
    <label>Téléphone</label>
    <input type="text" name="telephone">
    <label>Taille</label>
    <input type="number" step="0.01" name="taille">
    <label>Diagnostic</label>
    <textarea name="diagnostic"></textarea>
    <button type="submit">Enregistrer</button>
  </form>
</body>
</html>
