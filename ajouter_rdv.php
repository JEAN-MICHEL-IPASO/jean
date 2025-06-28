<?php
include 'db.php';
session_start();

// Charger la liste des patients
$patients = $conn->query("SELECT id, nom FROM patients ORDER BY nom");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Planifier un rendez-vous</title>
  <style>
    body {
       font-family: sans-serif; 
       padding: 40px; 
       max-width: 700px;
      display: flex; 
       text-align: center;
       margin-bottom: 25px;
       justify-content: center;
       align-items: center;
       margin: auto;
        background: #f0f0f0;
      }
    h2 { text-align: center;
       margin-bottom: 25px;}
       form{
        background:rgb(179, 96, 196);
       width: 100%;
border-radius: 10px;
        border-style: double;
        border-color: aqua;
        
       }
    label { 
      display: block; 
      margin-top: 15px;
       font-weight: bold;}
    input, select, textarea {
       width: 50%;
       padding: 8px;
        margin-top: 5px;
        border-radius: 10px;
        border-style: double;
        border-color: aqua;
      }
    button {
       margin-top: 20px;
       padding: 10px 20px;
       background: #2d3436;
        color: white;
         border:none;
          cursor: pointer;
          border-radius: 10px;
        border-style: double;
        border-color: aqua;
          transition: 3s;
      }
    button:hover {
       background: #0984e3;}
  </style>
</head>
<body>


  <form action="enregistrer_rdv.php" method="POST">
  <h2>📅 Ajouter un rendez-vous</h2>

    <label for="patient_id">Patient:</label>
    <select name="patient_id" id="patient_id" required>
      <option value="">-- Sélectionner un patient --</option>
      <?php while($p = $patients->fetch_assoc()):?>
        <option value="<?= $p['id']?>"><?= htmlspecialchars($p['nom'])?></option>
      <?php endwhile;?>
 </select>

    <label for="date_rdv">Date du rendez-vous:</label>
    <input type="date" name="date_rdv" required>

    <label for="heure">Heure:</label>
    <input type="time" name="heure" required>

    <label for="motif">Motif:</label>
    <input type="text" name="motif" required>

    <label for="statut">Statut:</label>
    <select name="statut" required>
      <option value="Prévu">Prévu</option>
      <option value="Effectué">Effectué</option>
      <option value="Annulé">Annulé</option>
    </select>

    <label for="commentaire">Commentaire (facultatif):</label>
    <textarea name="commentaire" rows="3"></textarea><br>

    <button type="submit">✅ Enregistrer le rendez-vous</button><br>
  </form>

</body>
</html>
