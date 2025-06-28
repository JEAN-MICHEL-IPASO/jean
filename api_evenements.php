<?php
include 'db.php';

$res = $conn->query("
  SELECT r.id, r.date_rdv, r.heure, r.statut, p.nom
  FROM rendez_vous r
  JOIN patients p ON r.patient_id = p.id
");

$events = [];

while ($rdv = $res->fetch_assoc()) {
  $events[] = [
    'id'    => $rdv['id'],
    'title' => $rdv['nom']. ' ('. $rdv['statut']. ')',
    'start' => $rdv['date_rdv']. 'T'. substr($rdv['heure'], 0, 5),
    'color' => match($rdv['statut']) {
      'Effectué' => '#27ae60',
      'Annulé'   => '#c0392b',
      'Prévu'    => '#3498db',
      default    => '#95a5a6'
}
  ];
}

header('Content-Type: application/json');
echo json_encode($events);
?>
