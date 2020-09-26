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


    <!--<div id="news" class='card white'>
        <div class="row">
            <div id="news1"class=" col s12 m6 l6">
                <h3 class="news-title">Nova versão</h3>
                <p>Versão alpha 0.8 da plataforma Inbooks foi lançada. Hooray!</p>
            </div>
            <div id='news2' class=" col s12 m6 l6">
                <h3 class="news-title">Aventuras de Juazineo</h3>
                <p>O livro as aventuras de juazineo está fazendo muito sucesso ultimamente</p>
                <p>Parabens para Takumi o criador desse livro!</p>
            </div>
        </div>
    </div>
    <div id="popularbooks"class = "row homebooks">
        <h2 class="white-text booksheader">Livros Populares</h2>
        <div class="col s4 l2 m3">
            <div class="card recommendedbook white">
                <div class="card-image">                
                    <img src="serverimages/15420497845be9cff83c1ca.png" class="citag">
                    <span class="card-title">As aventuras de Juazineo</span>
                    <a class="waves-effect orange darken-1 btn-floating halfway-fab" href="index.php?page=rebook&bookid=11"><i class="material-icons outlined">arrow_right</i></a>
                </div>
                <div class="card-content">
                    <p>Um livro sobre as aventuras de Juazineo na internet.</p>
                </div>
            </div>
        </div>
    </div>
    <div id ="recommendedbooks" class="row homebooks">
        <h2 class="white-text booksheader">Livros Recomendados</h2>
        <div class="col s4 l2 m3">
            <div class="card recommendedbook white">
                <div class="card-image">                
                    <img src="serverimages/15430174605bf893f46fee6.png" class="citag">
                    <span class="card-title">As aventuras de Throdthok</span>
                    <a class="waves-effect orange darken-1 btn-floating halfway-fab" href="index.php?page=rebook&bookid=11"><i class="material-icons outlined">arrow_right</i></a>
                </div>
                <div class="card-content">
                    <p>Um livro sobre Throdthok, o meio-orc.</p>
                </div>
            </div>
        </div>
    </div> -->

</div>

