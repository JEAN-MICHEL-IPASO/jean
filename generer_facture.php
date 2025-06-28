<?php
require 'autoload.php';
include 'db.php';
use Dompdf\Dompdf;
$id_facture = $_GET['id'];
$result = $conn->query("SELECT f.*, p.nom FROM facture f JOIN patients p ON f.patient_id = p.id WHERE f.id = $id_facture");
$data = $result->fetch_assoc();

$html = "
<h2 style='text-align:center;'>Facture N° {$data['numero_facture']}</h2>
<p><strong>Nom du patient:</strong> {$data['nom']}</p>
<p><strong>Date:</strong> {$data['date']}</p>
<hr>
<table width='100%' border='1' cellspacing='0' cellpadding='5'>
<tr><th>Désignation</th><th>Quantité</th><th>Prix unitaire</th><th>Prix total</th></tr>
<tr>
  <td>{$data['designation']}</td>
  <td>{$data['quantite']}</td>
  <td>{$data['prix_unitaire']} Fcfa</td>
  <td>{$data['prix_total']} Fcfa</td>
</tr>
</table>
<h3 style='text-align:right;'>Montant global: {$data['montant_global']} Fcfa</h3> 
";
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("facture_{$data['numero_facture']}.pdf", array("Attachment" => false));
?>
