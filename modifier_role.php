<?php
include 'db.php';
session_start();

// Sécurité: seul un admin peut modifier les rôles
if (!isset($_SESSION['role']) || $_SESSION['role']!== 'admin') {
    exit("⛔ Accès refusé.");
}

// Vérification des champs reçus
$id = isset($_POST['id'])? intval($_POST['id']): null;
$nouveau_role = $_POST['nouveau_role']?? null;

if ($id && in_array($nouveau_role, ['admin', 'médecin', 'laborantin'])) {
    $stmt = $conn->prepare("UPDATE utilisateurs SET rôle =? WHERE id =?");
    $stmt->bind_param("si", $nouveau_role, $id);
    $stmt->execute();
    header("Location: dashboard.php?message=modification_reussie");
    exit;
} else {
    // Affiche une erreur claire si l’un des champs est manquant ou invalide
    echo "❌ Erreur: Données manquantes ou rôle non autorisé.";
}
?>
