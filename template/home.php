<?php
if (isset($_SESSION['userid'])) {
    $user = new User($_SESSION['userid']);
}
?>
<script src='template/js/home.js'></script>
<style>
    body{
        background-repeat: no-repeat;
        background-size:cover;
        background-attachment: fixed;
        background-image:url('lib/images/tempbackground.jpg');
    }
</style>

<div id ="homepage" class="row">
    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper orange">
                <a class="brand-logo right">Bem vindo <?php echo $user->username ?></a>
                <ul id ="nav-mobile" class="left hide-on-med-and-down">
                    <li><a href="index.php?page=profile">Ver pagina pessoal</a></li>
                    <li><a href="index.php?page=booklist">Pesquisar livros</a></li>
                    <li><a href="logout.php">Sair</a></li>
                </ul>
            </div>
        </nav>
    </div>

</div>

