<?php 
$_GET['Titulo'] = 'Poll';
$_GET['idBody'] = 'bodyPoll';
?>
<?php include "header.php"; ?>
<div class="messages"></div>
<script src="./enquestes.js"></script>
    <?php
    $pdo = connectionBBDD();
    $stmt = $pdo ->prepare("SELECT q.text FROM question q;");            
    $stmt->execute();
    $row = $stmt->fetch();
    echo "<script>
    var arrayQuestions = [];\n";
    while($row){
        echo "arrayQuestions.push('".$row["text"]."');\n";
        $row = $stmt->fetch();
    }
    echo "</script>";
    ?>

<script>
    $(function() {
        viewListQuestion('#pollContent',arrayQuestions);
    });
</script>

<div class="containerPoll">
    <nav class="panel">
        <button id="crearPregunta" class="btnPanelAdmin">Crear Pregunta</button>
        <button id="crearEncuesta" class="btnPanelAdmin">Crear Enquesta</button>
        <button id="listarPreguntas" class="btnPanelAdmin">Llistat de Preguntes</button>
        <button id="listarEncuestas" class="btnPanelAdmin">Llistat d'Enquestes</button>
    </nav>
    <div class="pollContent" id="pollContent">

    </div>
</div>
<?php include "footer.php"; ?>