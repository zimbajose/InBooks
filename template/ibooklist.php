<script src="template/js/bllist.js"></script>
<style>body{
        overflow-y:hidden;
    }</style>
<div  class= "row"id ="booklistpage">
    <div class="nav-fixed">
        <nav>
            <div class="nav-wrapper orange">
                <a class="brand-logo center" onclick="openprofile()">Lista de livros</a>
                <ul>
                    <li> <a href="index.php?page=profile">Ir para o perfil</a></li>          
                    <li> <a href="index.php"> Voltar para a home</a>  </li>          
                </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col s12 m4 l4 orange accent-1" id="searchparameters">
            <div class="searching">
                <div class="input-field col s10 m10 l10">
                    <input type="text" id="chbookname" name="chbookname">
                    <label for ="chbookname">Nome do livro</label>
                </div>
                <div class="input-field col s10 m10 l10">
                    <input type="text" id="chbookgenre" name="chbookgenre">
                    <label for ="chbookname">Genero do livro</label>
                </div>
                <a class ="btn waves-light waves-effect green"onclick="searchbooks()">Pesquisar</a>
                <a class="btn waves-light waves-effect red" onclick="clean()">Limpar parametros</a>
            </div>
            <div class="searchtab">
                
            </div>
        </div>
        <div class="col s12 m8 l8" id="booksdiv" class="fillscreen">

        </div>
        <div id ="recommended" class="fillscreen col s12 m8 l8">

        </div>
        <div id ="hotbooks" class="fillscreen col s12 m8 l8" >

        </div>
    </div>
</div>