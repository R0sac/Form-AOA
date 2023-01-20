<?php 
$_GET['Titulo'] = 'Index';
$_GET['idBody'] = 'bodyLanding';

?>
<?php include "header.php"; ?>
<div id="divLanding">
    
    <form action="./login.php">
        <button type="submit" class='btnLanding'>LOGIN</button>
    </form>
</div>
<?php include "footer.php"; ?>