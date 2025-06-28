<?php
include 'db.php';
session_start();

// Vérifie la connexion utilisateur
if (!isset($_SESSION['id'])) {
    exit("⛔ Accès interdit. Veuillez vous connecter.");
}

// Liste des champs attendus
$champs = ['patient_id', 'provenance', 'zone_sante', 'aire_sante', 'formation', 'telephone',
           'nom_medecin', 'societe', 'matricule', 'date_deces', 'heure_deces', 'motif_deces'];

foreach ($champs as $champ) {
    if (empty($_POST[$champ])) {
        exit("❗ Le champ '$champ' est requis.");
}
}

// Récupération sécurisée des données du formulaire
$patient_id   = intval($_POST['patient_id']);
$provenance   = trim($_POST['provenance']);
$zone_sante   = trim($_POST['zone_sante']);
$aire_sante   = trim($_POST['aire_sante']);
$formation    = trim($_POST['formation']);
$telephone    = trim($_POST['telephone']);
$nom_medecin  = trim($_POST['nom_medecin']);
$societe      = trim($_POST['societe']);
$matricule    = trim($_POST['matricule']);
$date_deces   = $_POST['date_deces'];
$heure_deces  = $_POST['heure_deces'];
$motif_deces  = trim($_POST['motif_deces']);
// Vérifie que le patient existe
$verif = $conn->prepare("SELECT id FROM patients WHERE id =?");
$verif->bind_param("i", $patient_id);
$verif->execute();
$verif->store_result();

if ($verif->num_rows === 0) {
    exit("❌ Patient introuvable dans la base.");
}

// Insertion du certificat
$stmt = $conn->prepare("
    INSERT INTO certificat_deces
    (patient_id, provenance, zone_sante, aire_sante, formation, telephone,
     nom_medecin, societe, matricule, date_deces, heure_deces, motif_deces)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
");
$stmt->bind_param(
    "isssssssssss",
    $patient_id, $provenance, $zone_sante, $aire_sante, $formation,
    $telephone, $nom_medecin, $societe, $matricule,
    $date_deces, $heure_deces, $motif_deces
);

$stmt->execute();

// Redirection vers certificat_deces.php
$deces_id = $conn->insert_id;
header("Location: certificat_deces.php?id=$deces_id");
exit;
?>
