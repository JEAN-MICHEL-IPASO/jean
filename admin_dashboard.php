<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id']) || $_SESSION['role']!== 'admin') {
    exit("⛔ Accès refusé");
}

$nom = $_SESSION['nom']?? 'Administrateur';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Panneau Administrateur</title>
    <style>
nav{
  display: flex;
  justify-content: space-around;
  align-items: center;
  background-color: blue;
  margin: 10px;
  height: 50px;
}
h2{
  text-align: center;
}
a{
  background-color: rgb(170, 215, 215);
  height: 40px;
  border-radius: 7px;
 border-style: double;
  border-color: rgb(147, 126, 126);
  transition: 3s;
}
a:hover{
  background-color: beige;
}
 h1{
background-color: blue;
font-size: 50px;
border-radius: 8px;
}
.ok{
background-color: darkgreen;
font-size: 38px;
border-radius: 8px;
color: aliceblue;
}
.i{
width: 150px;
background-color: aquamarine;
}
.card { 
  background: white;
   padding: 20px; margin: 20px 0; 
   border-radius: 6px;
    box-shadow: 
    width:70px;
    0 0 5px rgba(0,0,0,0.1);}
    p{
      color:blue;
      font-size: 2rem;
    }
</style>
</head>
<body background="ip.jpg">
  <section>
     <h1><mark ="blue"> <center> <font color="white">CENTRE DE SANTE MERE ET ENFANT</font></center></mark></h1> 
      <nav>
    <a href="vue_medecin.php">🏥 Vue Médecin</a>
    <a href="vue_labo.php">🧪 Vue Laboratoire</a>
    <a href="dashboard.php">➕Parcourir</a>
    <a href="logout.php">🔓 Déconnexion</a>
    
    </nav>
   <div class="ok">
    <h2> <marquee behavior="" direction="">VOICI NOS SERVICES ORGANISES: Pédiatrie, Gynéco-Obstétrique, Chirurgie, médecine interne, Echographie, Ophtamologie, Dentistérie</marquee></h2>
    </div>
    <div class="i">
<h3>HEURES DE VISITE</h3>
<ul>
    <li>06h30-07h45</li>
    <li>12h00-13h30</li>
    <li>07h00-19h00</li>
</ul>
    </div>
    <div class="card">
    <h3>📌 Instructions</h3>
    <p>Pour bénéficier de l'expérience, veuillez cliquer sur ➕Parcourir </p>
  </div>

  </section>
   <footer style="text-align: center; font-size: 2em; color: blue; margin-top: 100px; background: yellow">
  © 2025 Tous droits réservés, Contactez-nous sur whatsApp: +243 811789989.




  <img src="0.jpg"style="border-raduis: 8px" alt="" >
</footer>
</body>
</html>
