<?php
include 'db.php';
session_start();

// Requête correcte: on sélectionne id, nom, prénom depuis la table patients
$patients = $conn->query("SELECT id, nom FROM patients ORDER BY nom");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter une facture</title>
  <style>
    body{
    background-image: url(xc.jpg);
    display: flex;
    justify-content: center;
   }
   input{
      margin:15px;
      padding: 5px;
      border-radius: 8px;
      border-radius: 8px;
    }
  section{
     margin:15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
   
   border-radius: 9px;
   background-color:rgb(134, 134, 251);
  }
  button{
    padding: 15px; 
   border-radius: 8px;
    transition: 3s;
    color: white;
    background: blue;
    font-size: 28px;
    margin: 12px;
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
   color: white; 
   
  }
  </style>
</head>
<body>
<section>
 
  <div class="tb">

  <form action="enregistrer_facture.php" method="POST">
  <div>
  <h2>➕ Nouvelle facture patient</h2><br>
</div><br>
    <label for="patient_id">Patient:</label><br>
    <select name="patient_id" id="patient_id" required>
      <option value="">-- Sélectionner un patient --</option>
      <?php while($p = $patients->fetch_assoc()):?>
 <option value="<?= $p['id']?>"><?= htmlspecialchars( $p['nom'])?></option>
      <?php endwhile;?>
    </select><br>

    <label for="numero_facture">Numéro de facture:</label><br>
    <input type="text" name="numero_facture" id="numero_facture" required><br>

    <label for="date">Date:</label><br>
    <input type="date" name="date" id="date" value="<?= date('Y-m-d')?>" required><br>
   </div>
 <div>
   <div>
    <label for="designation">Désignation:</label><br>
    <input type="text" name="designation" id="designation" required><br>
     </div>
 <div>
    <label for="quantite">Quantité:</label><br>
    <input type="number" name="quantite" id="quantite" min="1" step="1" required><br>
     </div>
 <div>
    <label for="prix_unitaire">Prix unitaire (FC):</label><br>
    <input type="number" name="prix_unitaire" id="prix_unitaire" min="0" step="0.01" required><br>
     </div>
 <div>
    <button type="submit">✅ Enregistrer</button><br>
     </div>
  </form>
 </div>
</section>
</body>
</html>
