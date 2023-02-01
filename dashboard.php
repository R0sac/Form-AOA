<?php
$_GET['Titulo'] = 'Dashboard';
$_GET['idBody'] = 'bodyDashboard';
$_GET['logout'] = '';

?>
<?php include "header.php";
$_SESSION["locationLogout"]= "dashboard.php"; ?>
<div id="divDash">
<?php
    if($_SESSION["user"][3] === 2){
        ?>
        <div id="Dashprofe">
            <a href="" id="dashProfePerfil" class="BtnDash">Perfil</a>
            <a href="stats.php" id="dashProfeEstats" class="BtnDash">Estadistiques</a>
        </div>
        <?php
    }
    elseif ($_SESSION["user"][3] === 1) {
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
            array_push($_SESSION["errors"],["error","Inicia la sessió"]);
            logButtonClick("E","login.php","S'ha intentat entrar sense iniciar sessió\n");//
            header("Location: login.php");
        }
        else{
            $_SESSION["errors"] = array();
            array_push($_SESSION["errors"],["error","Inicia la sessió"]);
            logButtonClick("E","login.php","S'ha intentat entrar sense iniciar sessió\n");//
            header("Location: login.php");
        }


    }
?>
</div>
<?php include "footer.php"; ?>
