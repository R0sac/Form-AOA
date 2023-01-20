<?php 
$_GET['Titulo'] = 'Dashboard';
$_GET['idBody'] = 'bodyDashboard';
$_GET['logout'] = '';

?>
<?php include "header.php"; ?>
<div id="divDash">
<?php
    if($_SESSION["usuario"][1] === "profe"){/*id=2*/
        ?>
        <div id="Dashprofe">
            <a href="" id="dashProfePerfil" class="BtnDash">Perfil</a>
            <a href="" id="dashProfeEstats" class="BtnDash">Estadistiques</a>
        </div>
        <?php
    }
    elseif ($_SESSION["usuario"][1] === "admin") {/*id=1*/
        ?>
            <div id="DashAdmin">
            <a href="" id="dashAdminUsuaris" class="BtnDash">Usuaris</a>
            <a href="" id="dashAdminEnquestes" class="BtnDash">Enquestes</a>
            <a href="" id="dashAdminEstats" class="BtnDash">Estadistiques</a>
        </div>
        <?php
    }
    else{
        
        header("Location: login.php");

    }
?>
</div>
<?php include "footer.php"; ?>
