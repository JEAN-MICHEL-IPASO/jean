<?php
include 'db.php';
session_start();

// Récupérer la liste des patients
$patients = $conn->query("SELECT id, nom FROM patients ORDER BY nom");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un examen</title>
   <style>
   body{
    background-image: url(e.jpg);
    display: flex;
    justify-content: center;
   }
   input{
      margin:15px;
      padding: 20px;
      border-radius: 8px;
      border-radius: 8px;
    }
  section{
     margin:15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
   
   border-radius: 9px;
   background-color: aqua;
  }
  button{
    padding: 15px;
   border-radius: 8px;
    transition: 3s;
  }
 button:hover{
  background-color: sienna;
 }
 label{
    padding: 15px;

 }
  .tb{
     margin:15px;
    border-radius: 50px;
    
  }
  select{
     margin:15px;
    width: 200px;
   border-radius: 8px;
 height: 40px;
  }
  h2{
   text-align: center;
   color: blue; 
  }
  </style>
</head>
<body>
<section>
<div>
  <form action="enregistrer_examen.php" method="POST">
  <h2>➕ Ajouter un examen de laboratoire</h2>

    <label>Patient:</label><br>
    <select name="patient_id" required>
      <option value="">-- Choisir un patient --</option>
      <?php while($p = $patients->fetch_assoc()):?>
        <option value="<?= $p['id']?>"><?= htmlspecialchars($p['nom'])?></option>
      <?php endwhile;?>
    </select><br>

    <label>Date:</label><br>
    <input type="date" name="date" required><br>

    <label>Type d’examen:</label>
<input type="text" name="type" required><br>
</div>
<div>
    <div>
    <label>Résultat (optionnel):</label><br>
    <textarea name="resultat" rows="3"></textarea><br>
</div>
<div>
    <label>Statut:</label><br>
    <select name="statut" required>
      <option value="En attente">En attente</option>
      <option value="Validé">Validé</option>
      <option value="Rejeté">Rejeté</option>
    </select><br>
</div>
<div>
    <button type="submit">💾 Enregistrer</button><br>
    </div>
  </form>
  </div>
</section>
</body>
</html>
