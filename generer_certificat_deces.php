<?php
require 'autoload.php';
include 'db.php';
use Dompdf\Dompdf;

$id = $_GET['id'];
$sql = "SELECT cd.*, p.nom, p.age, p.telephone, p.provenance, p.aire_sante
        FROM certificat_deces cd
        JOIN patients p ON p.id = cd.patient_id
        WHERE cd.id = $id";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

$html = "
<h2 style='text-align:center;'>Certificat de Décès</h2>
<p><strong>Nom:</strong> {$data['nom']}</p>
<p><strong>Âge:</strong> {$data['age']}</p>
<p><strong>Téléphone:</strong> {$data['telephone']}</p>
<p><strong>Provenance:</strong> {$data['provenance']}</p>
<p><strong>Aire de santé:</strong> {$data['aire_sante']}</p>
<p><strong>Date du décès:</strong> {$data['date_deces']}</p>
<p><strong>Heure:</strong> {$data['heure_deces']}</p>
<p><strong>Motif:</strong> {$data['motif_deces']}</p>
<p><strong>Médecin:</strong> {$data['nom_medecin']} ({$data['societe']})</p>
<p><strong>Matricule:</strong> {$data['matricule']}</p>
";

$dompdf = new Dompdf();
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("certificat_deces_{$data['nom']}.pdf", array("Attachment" => false));

?>
