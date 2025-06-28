<?php
include 'db.php';
$res = $conn->query("SELECT sexe, COUNT(*) as total FROM patients GROUP BY sexe");
$data = ['labels' => [], 'values' => []];
while ($row = $res->fetch_assoc()) {
  $data['labels'][] = $row['sexe'];
  $data['values'][] = $row['total'];
}	
echo json_encode($data);
?>
