<?php 
$_GET['Titulo'] = 'Index';
$_GET['idBody'] = 'bodyLanding';

include "header.php";
?>
<div id="divLanding">
    
    <form action="./login.php" method='POST'>
        <button type="submit" class='btnLanding' name='systemLog'>LOGIN</button>
    </form>
</div>
<?php include "footer.php"; ?>