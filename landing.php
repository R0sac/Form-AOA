<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <title>Landing</title>
</head>
<body id='bodyLanding'>
    <div class='landingH1'>
        <center><h1 class= 'h1Landing'>Enquesta Professors</h1></center>
    </div>
    <p>
    Tindrem 3 tipus d'usuaris: admin, professor i alumne.<br>
Els admins podran:<br>
  - crear preguntes i classficar-les en categories<br>
  - crear, editar i convidar alumnes a enquestes (via email)<br>
  - gestionar el usuaris admins i professors<br><br>
 
Els usuaris professors:<br>
  - podran visualitzar les estadístiques de les seves enquestes.<br><br>

Els usuaris alumne:<br>
  - no podran fer login, ni tindran cap dashboard<br>
  - només podran rebre invitacions (via email) per a respondre enquestes de professorat<br><br>

Una enquesta serà un conjunt de preguntes associades a un professor, amb data d'inici i data final.<br><br>

Tindrem 3 tipus de preguntes:<br>
  - opció simple (menú desplegable/radio button)<br>
  - resposta numèrica de 0 al 5 (molt en desacord ... molt d'acord)<br>
  - resposta oberta<br>
  - opció múltiple (checkboxes)<br>

Els alumnes rebran una invitació via email quan l'admin publiqui l'enquesta.<br><br>

Els alumnes tindran disponible una pàgina on podran posar el seu email, al qual rebran una llista d'enquestes pendents de respondre, i una altra llista d'enquestes ja respostes (només lectura).<br>

    </p>
    <form action="./login.php">
        <center><button type="submit" class='landingButton'>LOGIN</button></center>
    </form>
</body>
</html>