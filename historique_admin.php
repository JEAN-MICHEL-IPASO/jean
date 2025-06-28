<?php
include 'db.php';
session_start();
if ($_SESSION['role']!== 'admin') exit("⛔");

$res = $conn->query("SELECT j.*, u.nom FROM journal_admin j JOIN utilisateurs u ON j.admin_id = u.id ORDER BY j.date DESC");
echo "<h3>Journal des actions administratives</h3><table border='1'><tr><th>Date</th><th>Admin</th><th>Action</th><th>Cible</th></tr>";
while ($row = $res->fetch_assoc()) {
  echo "<tr><td>{$row['date']}</td><td>{$row['nom']}</td><td>{$row['action']}</td><td>{$row['cible']}</td></tr>";
}
echo "</table>";
?>
