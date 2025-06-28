<?php
include 'db.php';

$options = new Options();
$options->set('defaultFont', 'DejaVu Sans');
$dompdf = new Dompdf($options);

// Requête pour récupérer les consultations de la semaine
$sql = "
  SELECT nom, age, sexe, date_consultation
  FROM patients
  WHERE WEEK(date_consultation, 1) = WEEK(CURDATE(), 1)
    AND YEAR(date_consultation) = YEAR(CURDATE())
";
$res = $conn->query($sql);

// Génération du contenu HTML
$html = "<h2 style='text-align:center;'>📆 Rapport hebdomadaire des consultations</h2>";
$html.= "<table border='1' cellspacing='0' cellpadding='5' width='100%'>
  <tr style='background:#f1f1f1;'>
    <th>Nom</th>
    <th>Âge</th>
    <th>Sexe</th>
    <th>Date de consultation</th>
  </tr>";

while ($row = $res->fetch_assoc()) {
  $html.= "<tr>
    <td>". htmlspecialchars($row['nom']). "</td>
    <td>". htmlspecialchars($row['age']). "</td>
    <td>". htmlspecialchars($row['sexe']). "</td>
 <td>". htmlspecialchars($row['date_consultation']). "</td>
  </tr>";
}

$html.= "</table>";

// Construction du PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Forcer le téléchargement du fichier PDF
$dompdf->stream("rapport_consultations_semaine.pdf", ["Attachment" => true]);
?>
