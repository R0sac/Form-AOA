<?php 
$_GET['Titulo'] = 'Dashboard';
$_GET['idBody'] = 'bodyDashboard';
?>
<?php include "header.php"; ?>
<div id="divDash">
<?php
    if($_SESSION["user"][3] === 2){
        ?>
        <div id="Dashprofe">
            <button id="dashProfePerfil" class="BtnDash">Perfil</button>
            <button id="dashProfeEstats" class="BtnDash">Estadistiques</button>
        </div>
        <?php
    }
    elseif ($_SESSION["user"][3] === 1) {
        ?>
            <div id="DashAdmin">
            <button id="dashAdminUsuaris" class="BtnDash">Usuaris</button>
            <button id="dashAdminEnquestes" class="BtnDash" onclick="changeLocation('poll')">Enquestes</button>
            <button id="dashAdminEstats" class="BtnDash">Estadistiques</button>
        </div>
        <?php
    }
    else{
        echo $_SESSION["user"][3];
    }
?>
</div>
<?php include "footer.php"; ?>
