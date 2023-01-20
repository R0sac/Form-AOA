<?php 
$_GET['Titulo'] = 'Poll';
$_GET['idBody'] = 'bodyPoll';
?>
<?php include "header.php"; ?>
<div class="dashboard">
    <nav class="panel">
        <button id="crearPregunta" class="btnPanelAdmin">Crear Pregunta</button>
        <button id="crearEncuesta" class="btnPanelAdmin">Crear Enquesta</button>
        <button id="listarPreguntas" class="btnPanelAdmin">Llistat de Preguntes</button>
        <button id="listarEncuestas" class="btnPanelAdmin">Llistat d'Enquestes</button>
    </nav>
    <div class="dash-contenido">
        <div class="contentRs">
            <?php

            ?>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>