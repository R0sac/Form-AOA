<?php 
$_GET['Titulo'] = 'Index';
$_GET['idBody'] = 'bodyLanding';

include "header.php";
?>
<div class="animation">
    <img src="https://img.icons8.com/clouds/100/null/form.png" class="poll-cloud animationIcon" width="100" height="100"/>
    <img src="https://img.icons8.com/bubbles/100/null/comments.png" class="comment animationIcon" width="100" height="100"/>
    <img src="https://img.icons8.com/bubbles/100/null/open-envelope.png" class="email-open animationIcon" width="100" height="100"/>
    <img src="https://img.icons8.com/clouds/100/null/speech-bubble.png" class="comment2 animationIcon" width="100" height="100"/>
    <img src="https://img.icons8.com/clouds/100/null/new-post.png" class="email-cloud animationIcon" width="100" height="100"/>
</div>
<div id="divLanding">
    <a href="login.php" id="btnLogin">Inici Sessió</a>
    <a href="get_polls.php" id="btnLogin">Alumnat</a>
</div>
<?php include "footer.php"; ?>