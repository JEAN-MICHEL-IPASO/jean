<!DOCTYPE html>
<html lang="fr">
<head>	
  <meta charset="UTF-8">
  <title>Bon de laboratoire</title>
  <style>
   body{
    background-image: url(a.jpg);
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

  <div bt>
  <h2>Bon de laboratoire</h2>

  <form action="enregistrer_laboratoire.php" method="POST">
    <label>Nom du patient</label><br>
    <input type="text" name="nom" required><br>
    <label>Âge</label><br>
    <input type="number" name="age" required><br>
    <label>Sexe</label><br>
    <select name="sexe"><option>Masculin</option><option>Féminin</option></select><br>
    </div>
    <div>
      <div>
<input class="tb" type="image" src="t.jpg" width="100" height="100" >
</div>
<div>
    <label>Adresse</label><br>
    <input type="text" name="adresse"><br>
    </div>
    <div>
    <label>Date</label><br>
    <input type="date" name="date"><br>
    </div>
    <div>
    <label>Examen demandé</label><br>
    <textarea name="examen" rows="4" required></textarea><br>
    </div>
    <button type="submit">Enregistrer</button><br>
  </form>
</div>
</section>
</body>
</html>
