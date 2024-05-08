<h3 class="text-center" >Entrer une signature : </h3>
<canvas id="signatureCanva" width="400" height="200" class="bg-white"></canvas>
<form id="signatureFormulaire" action="back/genPDF<?=$_GET['reload']=='1'?'?reload=1':'' ;?>" method="post">
    <input type="hidden" id="signatureBase64" name="signatureBase64">
    <button type="button" onclick="saveSignature()">Enregistrer</button>
</form>
<script src="js/canva.js"></script>