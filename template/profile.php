<?php
if(!isset($_SESSION['userid'])){
    header('Location:index.php?page=login');
}
    $user = new User($_SESSION['userid']);
    $id = $_SESSION['userid'];
    
?>
<script src="template/js/profile.js"></script>
<style>
    body{
        overflow-y: hidden;
    }
</style>
<div id="profilepage" data-userid="<?php echo $id ?>">
    <nav>
    <div class="nav-wrapper orange">
        <a class="brand-logo right" onclick="openprofile()"><?php echo $user->username  ?></a>
        <ul>
            <a class="" onclick="select(1)"><li class="active pagelink" id="pagelink1" >Livros em edição</li></a>
            <a  onclick="select(0)"><li class="pagelink" id="pagelink0">Livros lançados</li></a>
            <a onclick="select(2)"><li class="pagelink" id="pagelink2">Livros que estou lendo</li></a>
            <a href="index.php"><li>Voltar para a home</li></a>
            
        </ul>
    </nav>
   
        <div class="row userbooklist" id="releasedbooks">
            <div class="orange lighten-4 col s12 m4 l4" id="bookinfo">
                <div id ="bookinfobox" class="profilebox orange lighten-3">
                    
                </div>
            </div>
            <div class="col s12 l8 m8" id="booklist">
                
            </div>
        </div>
     <div class="row userbooklist" id="booksimreading">
            <div class="orange lighten-4 col s12 m4 l4" id="myinfo">
                <div id = "myinfobox" class="profilebox orange lighten-3">
                    
                </div>
            </div>
            <div class="col s12 l8 m8" id="rebooklist">
                
            </div>
        </div>
        <div class="row userbooklist" id="unreleasedbooks">
            <div class=" orange lighten-4 col s12 m4 l4" id="bookpanel">
                 
                <div id="bookpanelbox" class="panel orange lighten-3">
                    
                </div>
               
            </div>
            <div class="col s12 m8 l8" id="unbooklist">
               
            </div>
        </div>
        <!--Modals da página -->
        <div class="modal" id="confirmbookdelete">
            <div class="modal-content">
                <h4>Deletar Livro</h4>
                <p>Você tem certeza que deseja deletar esse livro? após deletado ninguem nunca mais podera acessar esse livro.</p>
            </div>
            <div class="modal-footer">
                <a class ="red btn waves-light waves-effect right"onclick="confirmDeletion()">Deletar</a>
            </div>
        </div>
</div>