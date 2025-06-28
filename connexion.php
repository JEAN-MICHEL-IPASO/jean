<?php
include 'db.php';
session_start();

$identifiant = $_POST['identifiant'];
$mot_de_passe = $_POST['mot_de_passe'];

$sql = "SELECT * FROM utilisateurs WHERE identifiant =?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $identifiant);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['role'] = $user['rôle'];

        // Redirection personnalisée
        if ($user['rôle'] === 'admin') {
            header("Location:admin_dashboard.php");
} elseif ($user['rôle'] === 'médecin') {
            header("Location:dashboard_medecin.php");
} elseif ($user['rôle'] === 'laborantin') {
            header("Location:dashboard_laborantin.php");
} else {
            echo "Rôle non reconnu.";
}
        exit;
} else {
        echo "Mot de passe incorrect.";
}
} else {
    echo "Utilisateur non trouvé.";
}
?>
