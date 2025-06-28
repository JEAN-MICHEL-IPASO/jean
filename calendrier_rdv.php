<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Agenda des rendez-vous</title>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <style>
    body { font-family: sans-serif; padding: 30px; max-width: 1000px; margin: auto; background: #f8f9fa;}
    h2 { text-align: center; margin-bottom: 30px;}
    #calendar { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ddd;}
.fc-event-title { font-weight: bold;}
  </style>
</head>
<body>

  <h2>📅 Agenda des rendez-vous</h2>
  <div id="calendar"></div>

  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const calendarEl = document.getElementById('calendar');

      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        timeZone: 'local',
        height: "auto",
        headerToolbar: {
          left: 'prev,next today',
 center: 'title',
          right: 'dayGridMonth,timeGridWeek,listWeek'
},
        javascript
eventClick: function(info) {
  alert("📄 Rendez-vous de " + info.event.title);
},


javascript
eventClick: function(info) {
  const rdv = info.event;
  const date = rdv.start.toLocaleDateString();
  const heure = rdv.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit'});
  const id = rdv.id;
  ouvrirModal(
    "📋 Rendez-vous de " + rdv.title,
    `📅 ${date}\n⏰ ${heure}`,
    `modifier_rdv.php?id=${id}`
);
},


<!-- Fenêtre modale (masquée par défaut) -->
<div id="modal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); justify-content:center; align-items:center;">
  <div style="background:white; padding:20px; border-radius:8px; width:300px; max-width:90%;">
    <h3 id="modal-title">📋 Détails du RDV</h3>
    <p id="modal-content"></p>
    <div style="text-align:right; margin-top:15px;">
      <a href="#" id="modifier-link" class="btn" style="padding:6px 12px; background:#0984e3; color:white; text-decoration:none; border-radius:4px;">✏ Modifier</a>
      <button onclick="fermerModal()" style="margin-left:10px;">Fermer</button>
    </div>
  </div>
</div>

<script>
function ouvrirModal(titre, contenu, lien) {
  document.getElementById('modal-title').textContent = titre;
  document.getElementById('modal-content').textContent = contenu;
  document.getElementById('modifier-link').href = lien;
  document.getElementById('modal').style.display = 'flex';
}
function fermerModal() {
  document.getElementById('modal').style.display = 'none';
}
</script>

</body>
</html>
