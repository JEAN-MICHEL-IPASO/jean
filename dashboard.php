<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id'])) {
  header('Location: login.php');
  exit;
}

$nom = $conn->query("SELECT nom FROM utilisateurs WHERE id = {$_SESSION['id']}")->fetch_row()[0];
$role = $_SESSION['role'];
$nb_patients = $conn->query("SELECT COUNT(*) FROM patients")->fetch_row()[0];
//nb_deces = $conn->query("SELECT COUNT(*) FROM deces")->fetch_row()[0];
//$nb_utilisateurs = $conn->query("SELECT COUNT(*) FROM utilisateurs")->fetch_row()[0];

//$conn->query("INSERT INTO journal_admin (admin_id, action, cible) VALUES ({$_SESSION['id']}, 'Ajout patient', '$nom')");
//$res = $conn->query("SELECT * FROM deces ORDER BY date_deces DESC");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tableau de bord</title>
  <style>
    body { 
      font-family:sans-serif;
       background-image: url(0.jpg);
       margin: 0;}
    header { 
      background: #2d3436; 
      color: white; 
      padding: 20px;}
    section {
      display: flex;
      justify-content: space-between;
      align-items: center;
        background-image: url(0.jpg);
       padding: 10px 20px;}
    nav a { margin-right: 15px;
      width: 100px;
       text-decoration: none;
       color: #0984e3;}
    main { padding: 20px;}
.card { 
  background: white;
   padding: 20px; margin: 20px 0; 
   border-radius: 6px;
    box-shadow: 
    0 0 5px rgba(0,0,0,0.1);}
    .tr{
      background: blue;
      border-radius: 10px;
      padding: 20px; 
    }
  </style>
</head>
<body>

<header>
  <h1>Bienvenue <?= ucfirst($role)?>, <?= htmlspecialchars($nom)?> 👋</h1>
</header>
<section>
<div class="tr">
<nav>
  <a href="fiche_consultation.php"><button style="padding: 10px 20px; background-color:rgb(9, 11, 174); color: white; border: none; border-radius: 4px; cursor: pointer;">
   🩺 Consultation
  </button></a><p>
  <a href="ordonnance.php"><button style="padding: 10px 20px; background-color:rgb(9, 11, 174); color: white; border: none; border-radius: 4px; cursor: pointer;">
   💊 Ordonnance
  </button></a><p>
    <a href="ajouter_deces.php"><button style="padding: 10px 20px; background-color:rgb(9, 11, 174); color: white; border: none; border-radius: 4px; cursor: pointer;">
   ajouter deces
  </button></a><p>
  <a href="bon_labo.php"><button style="padding: 10px 20px; background-color:rgb(136, 249, 7); color: white; border: none; border-radius: 4px; cursor: pointer;">
    🧪 Laboratoire
  </button></a><p>
  <a href="liste_rdv.php"><button style="padding: 10px 20px; background-color:rgb(71, 3, 9); color: white; border: none; border-radius: 4px; cursor: pointer;">
    📆 Rendez-vous
  </button></a><p>
  <a href="liste_patients.php"><button style="padding: 10px 20px; background-color:rgb(6, 112, 131); color: white; border: none; border-radius: 4px; cursor: pointer;">
    📋 Tous les patients
  </button></a><p>



  <?php if ($role === 'admin'):?>
    <a href="admin_dashboard.php">🔧 Panneau Admin</a><p>
  <?php endif;?>
  <a href="logout.php">🔓 Déconnexion</a><p>
</nav>
</div>
<div>
<main>
  <div class="card">
    <h3>📌 Instructions</h3>
    <p>Sélectionnez une action dans le menu ci-dessus pour accéder aux différents modules. Chaque module est adapté selon votre rôle utilisateur.</p>
  </div>

  <div class="card">
    <h3>📅 Info du jour</h3>
    <?php
    $aujourdhui = date('Y-m-d');
    $rdv = $conn->query("SELECT COUNT(*) FROM rendez_vous WHERE date_rdv = '$aujourdhui'")->fetch_row()[0];
    echo "<p>Rendez-vous aujourd’hui : <strong>$rdv</strong></p>";
?>
  </div>
</main>
</div>
<div class="tr">
<a href="liste_deces.php"><button style="padding: 10px 20px; background-color:rgb(16, 7, 1); color: white; border: none; border-radius: 4px; cursor: pointer;">
    ⚰ Cas de décès⚰️
  </button></a><p> <br>
<a href="ajouter_rdv.php"><button style="padding: 10px 20px; background-color:rgb(231, 100, 6); color: white; border: none; border-radius: 4px; cursor: pointer;">
    ➕ Nouveau rendez-vous
  </button></a><p><br>
<a href="historique_admin.php"><button style="padding: 10px 20px; background-color:rgb(15, 6, 146); color: white; border: none; border-radius: 4px; cursor: pointer;">
    📜 Journal des actions
  </button></a><p><br>
<a href="stats_menquelles.php"><button style="padding: 10px 20px; background-color:rgb(16, 220, 81); color: white; border: none; border-radius: 4px; cursor: pointer;">
    📊statistique
  </button> </a><p><br>
<a href="modifier_role_form.php"><button style="padding: 10px 20px; background-color:rgb(193, 14, 14); color: white; border: none; border-radius: 4px; cursor: pointer;">
    📄modifier
  </button></a><p><br>
<a href="dashboard_factures.php"><button style="padding: 10px 20px; background-color:rgb(161, 36, 140); color: white; border: none; border-radius: 4px; cursor: pointer;">
    📄Gerer les factures
  </button></a><p><br>
<a href="rapport_hebdo.php"> <button style="padding: 10px 20px; background-color: #0984e3; color: white; border: none; border-radius: 4px; cursor: pointer;">
    ⬇rapport hebdomadaire
  </button></a><p><br>
  </div>
</section>
</body>
</html>
