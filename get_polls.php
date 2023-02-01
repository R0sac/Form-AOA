<?php 
$_GET['Titulo'] = 'Llistar enquestes';
$_GET['idBody'] = 'bodyGetPolls';
?>
<?php include "header.php"; ?>

<div class='autocenter'>
    <div id='divLogin'>
        <h1>Consultar enquestes</h1>
        <form class='formSendPollStudent' id ='formSendPollStudent' action='./checkForm.php' method='post'>
            <label for='inputSendPollsStudent'>Introdueix un correu</label>
            <input name='inputSendPollsStudent' id='inputSendPollsStudent' type='text'>
            <br>
            <button class='btnSubmit' id='btnSubmitPollStudent' type='button'>Enviar</button>
        </form>
    </div>
</div>

<script>
    $( document ).ready(function() {
        $('#btnSubmitPollStudent').click(() => {
            submitSendPollsToStudent();
        });
    });
</script>
<?php include "footer.php"; ?>