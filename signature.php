<h3 class="text-center" >Entrer une signature : </h3>
<canvas id="signatureCanvas" width="400" height="200" class="bg-white"></canvas>
<form id="signatureForm" action="back/save_signature" method="post">
    <input type="hidden" id="signatureData" name="signatureData">
    <button type="button" onclick="saveSignature()">Enregistrer</button>
</form>
<script src="js/canva.js"></script>
