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
            <a href="poll.php" id="dashAdminEnquestes" class="BtnDash">Enquestes</a>
            <a href="" id="dashAdminEstats" class="BtnDash">Estadistiques</a>
        </div>
        <?php
    }
    else{
        if(issetErrors()){
            echo "<script>console.log(".$_SESSION["errors"].");</script>";
            array_push($_SESSION["errors"],["error","Inicia la sessió"]);
            header("Location: login.php");
        }
        else{
            $_SESSION["errors"] = array();
            array_push($_SESSION["errors"],["error","Inicia la sessió"]);
            header("Location: login.php");
        }


    }
?>
</div>
<?php include "footer.php"; ?>
