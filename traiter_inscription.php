<?php
include 'db.php';
session_start();

if (isset($_POST['nom'], $_POST['identifiant'], $_POST['mot_de_passe'], $_POST['rôle'])) {
    $nom = trim($_POST['nom']);
    $identifiant = trim($_POST['identifiant']);
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $rôle = $_POST['rôle'];

    // Optionnel: validation de l’identifiant
    if (!preg_match('/^[a-zA-Z0-9._-]{3,30}$/', $identifiant)) {
        $_SESSION['message'] = "Identifiant invalide (lettres, chiffres, -, _).";
        header("Location: inscription.php");
        exit;
}

    // Vérifier que l’identifiant n’existe pas déjà
    $check = $conn->prepare("SELECT id FROM utilisateurs WHERE identifiant =?");
    $check->bind_param("s", $identifiant);
    $check->execute();
    $check->store_result();
    if ($check->num_rows> 0) {
        $_SESSION['message'] = "Identifiant déjà utilisé.";
        header("Location: inscription.php");
        exit;
}
 // Insertion
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, identifiant, mot_de_passe, rôle) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $nom, $identifiant, $mot_de_passe, $rôle);
    $stmt->execute();

    $_SESSION['message'] = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
    header("Location: login.php");
    exit;
} else {
    $_SESSION['message'] = "Veuillez remplir tous les champs.";
    header("Location: inscription.php");
    exit;
}
?>
