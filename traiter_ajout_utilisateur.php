<?php
session_start();
include 'db.php';

if (isset($_POST['nom'], $_POST['identifiant'], $_POST['mot_de_passe'], $_POST['role'])) {
    $nom = trim($_POST['nom']);
    $identifiant = trim($_POST['identifiant']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $role = trim($_POST['role']);

    // Validation identifiant
    if (!preg_match('/^[a-zA-Z0-9._-]{3,30}$/', $identifiant)) {
        $_SESSION['message'] = "⚠ Identifiant invalide (lettres, chiffres, tirets, points autorisés).";
        header("Location: ajouter_utilisateur.php");
        exit;
}

    // Vérifie unicité de l'identifiant
    $check = $conn->prepare("SELECT id FROM utilisateurs WHERE identifiant =?");
    $check->bind_param("s", $identifiant);
    $check->execute();
    $check->store_result();

    if ($check->num_rows> 0) {
        $_SESSION['message'] = "❌ Identifiant déjà utilisé.";
        header("Location: ajouter_utilisateur.php");
        exit;
}

    // Hachage du mot de passe
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);
 // Insertion
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, identifiant, mot_de_passe, rôle) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $nom, $identifiant, $mot_de_passe_hache, $role);
    $stmt->execute();

    $_SESSION['message'] = "✅ Utilisateur ajouté avec succès.";
    header("Location: ajouter_utilisateur.php");
    exit;
} else {
    $_SESSION['message'] = "❗ Veuillez remplir tous les champs.";
    header("Location: ajouter_utilisateur.php");
    exit;
}
?>
