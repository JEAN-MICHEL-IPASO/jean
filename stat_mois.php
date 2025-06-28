<?php
include 'db.php';

$mois_fr = [1 => "Jan", "Fév", "Mar", "Avr", "Mai", "Juin",
            "Juil", "Août", "Sep", "Oct", "Nov", "Déc"];

// Initialiser tous les mois à zéro
$data = ['labels' => [], 'values' => []];
for ($i = 1; $i <= 12; $i++) {
    $data['labels'][$i] = $mois_fr[$i];
    $data['values'][$i] = 0;
}

$res = $conn->query("
    SELECT MONTH(date_consultation) AS mois, COUNT(*) AS total
    FROM patients
    WHERE date_consultation IS NOT NULL
    GROUP BY mois
");

while ($row = $res->fetch_assoc()) {
    $mois = (int) $row['mois'];
    if ($mois>= 1 && $mois <= 12) {
        $data['values'][$mois] = (int) $row['total'];
}
}

// Réindexer les tableaux proprement
$data['labels'] = array_values($data['labels']);
$data['values'] = array_values($data['values']);

echo json_encode($data);
?>
