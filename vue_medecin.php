<?php
include 'db.php';
session_start();

// Récupérer tous les médecins
$medecins = $conn->query("SELECT id, nom FROM medecins ORDER BY nom");

// Filtres
$filtre_medecin = $_GET['medecin_id']?? '';
$filtre_date    = $_GET['date']?? '';
$filtre_statut  = $_GET['statut']?? '';

// Requête principale (si médecin sélectionné)
$rdvs = [];
if ($filtre_medecin) {
  $like_date = $filtre_date?: '%';
  $like_statut = $filtre_statut?: '%';

  $stmt = $conn->prepare("
    SELECT r.*, p.nom AS patient_nom
    FROM rendez_vous r
    JOIN patients p ON r.patient_id = p.id
    WHERE r.medecin_id =?
      AND r.date_rdv LIKE?
      AND r.statut LIKE?
    ORDER BY r.date_rdv, r.heure
  ");
  $stmt->bind_param("iss", $filtre_medecin, $like_date, $like_statut);
  $stmt->execute();
  $res = $stmt->get_result();
  while ($row = $res->fetch_assoc()) {
    $rdvs[] = $row;
}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Vue Médecin</title>
<style>
    body {
       font-family: sans-serif;
       padding: 30px; 
       max-width: 1000px;
        margin: auto;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;

         background: #f7f9fa;
        }
    h2 {
       text-align: center; 
      margin-bottom: 25px;
    }
    form {
      background-color: #522f5b;
       display: flex;
       flex-wrap: wrap; 
       gap: 15px; 
      align-items: center;
       margin: 20px;
       width: 411px ;
      }
    select, input {
       padding: 6px; 
       margin: 15px;
       width: 352px;
       border-radius: 10px;
      }
    table {
       width: 100%;
       border-collapse: collapse;
       background: white;}
    th, td { 
      padding: 10px;
       border: 1px solid #ddd; 
       text-align: left;
      }
    th {
       background: #ecf0f1;
      }
Button {
       text-align: center;
   background-color: #522f5b;
       display: flex;
       flex-wrap: wrap; 
       gap: 50%; 
      align-items: center;
       margin: 30px;
       width: 411px
  padding: 15px 10px;
   background:rgb(87, 158, 175); 
   color: white; text-decoration:
    none;
    
     border-radius: 10px; 
     font-size: 15px;
    }
.statut {
   font-weight: bold;
}
.Prévu {
   color: #0984e3;
  }
.Effectué { 
  color: #27ae60;
}
.Annulé {
   color: #c0392b;
  }
  </style>
</head>
<body>


  <form method="get">
  <h2>🩺 Rendez-vous par Médecin</h2><br>

    <select name="medecin_id" required>
      <option value="">-- Sélectionner un médecin --</option>
      <?php while($m = $medecins->fetch_assoc()):?>
        <option value="<?= $m['id']?>" <?= $filtre_medecin == $m['id']? 'selected': ''?>>
          <?= htmlspecialchars($m['nom'])?>
        </option>
      <?php endwhile;?>
    </select><br>

    <input type="date" name="date" value="<?= htmlspecialchars($filtre_date)?>"><br>
    <select name="statut">
      <option value="">Tous les statuts</option>
      <option value="Prévu"    <?= $filtre_statut === 'Prévu'? 'selected': ''?>>Prévu</option>
      <option value="Effectué" <?= $filtre_statut === 'Effectué'? 'selected': ''?>>Effectué</option>
      <option value="Annulé"   <?= $filtre_statut === 'Annulé'? 'selected': ''?>>Annulé</option>
    </select><br>

    <button type="submit">🔍 Filtrer</button><br>
  </form>

  <?php if ($filtre_medecin):?>
    <table>
      <tr>
        <th>Date</th>
        <th>Heure</th>
        <th>Patient</th>
        <th>Motif</th>
        <th>Statut</th>
        <th>Commentaire</th>
      </tr>
      <?php foreach ($rdvs as $r):?>
      <tr>
        <td><?= $r['date_rdv']?></td>
        <td><?= substr($r['heure'], 0, 5)?></td>
        <td><?= htmlspecialchars($r['patient_nom'])?></td>
        <td><?= htmlspecialchars($r['motif'])?></td>
        <td class="statut <?= $r['statut']?>"><?= $r['statut']?></td>
        <td><?= nl2br(htmlspecialchars($r['commentaire']))?></td>
      </tr>
      <?php endforeach;?>
    </table>
  <?php endif;?>

</body>
</html>
