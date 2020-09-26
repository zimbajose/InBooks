<?php
$ibook = filter_input(INPUT_GET, 'book', FILTER_SANITIZE_NUMBER_INT);
$book = new Ibook($ibook);
if (!isset($_SESSION['userid'])) {
    header('Location:index.php?page=login');
}
if ($_SESSION['userid'] != $book->user_id || $book->released == 1) {
    header('Location:index.php?page=profile');
}

set_error_handler(function() {
    
});
if (isset($_FILES['coverupload']['name']) && ($_FILES['coverupload']['errors'] == 0)) {

    $arquivo_tmp = $_FILES['coverupload']['tmp_name'];
    $nome = $_FILES['coverupload'] ['name'];
    $extensao = pathinfo($nome, PATHINFO_EXTENSION);
    $extensao = strtolower($extensao);
    if (strstr('.jpg;.jpeg;.gif;.png', $extensao)) {

        $novonome = uniqid(time()) . '.' . $extensao;
        $destino = 'serverimages/' . $novonome;
        if (@move_uploaded_file($arquivo_tmp, $destino)) {

            $str = $book->cover_path;
            if ($str) {
                unlink($str);
            }
            $book->cover_path = $destino;
            $book->save();
        }
    }
}
?>
<script src="lib/Trumbowyg/dist/trumbowyg.js"></script>
<link rel = "stylesheet" href="lib/Trumbowyg/dist/ui/trumbowyg.min.css">
<script src="lib/Trumbowyg/dist/plugins/colors/trumbowyg.colors.min.js"></script>
<link rel ="stylesheet" href="lib/Trumbowyg/dist/plugins/colors/ui/trumbowyg.colors.min.css">
<script src="lib/Trumbowyg/dist/plugins/fontsize/trumbowyg.fontsize.min.js"></script>

<script src="template/js/cebook.js"></script>
<div id ='createbookpage' class = 'row' data-bookid ="<?php echo $ibook ?>">
    <div class="navbar-fixed">
        <nav>
            <div class='nav-wrapper row orange' id='cbooknav'>
                <a class = "waves-effect waves-light btn left green accent bookoptbtn" id="generalbutton" onClick="openGeneral()">Geral do livro</a>
                <a class = "waves-effect waves-light btn left cyan accent bookoptbtn" id="returnbutton" onClick = "returntotree()">Retornar a arvore</a>
                <a class="waves-effect waves-light btn right red accent-3"id="leavebutton" href="index.php?page=profile">Sair da edição</a>
            </div>
        </nav>    
    </div>
    <!--Div de exibição de textos-->
    <div id ="textscontainer" class="row">

    </div>   
    <!--Div de edição de um texto unico -->

    <div class = "row" id="textcontainer">

    </div>
    <!--Modals do site-->

    <div id ="generalconfigmodal" class = "modal">
        <div class = "modal-content">
            <div class = "row">
                <i class="material-icons right" onClick="closeGeneral()" class="modal-close">close</i> 
            </div>
            <div class="row" id="configedit">     
                <div class="col l6 m6 s6" id="bookforms">
                    <div class="input-field">
                        <i class="material-icons prefix">book</i>
                        <input id="bookname" name="bookname" type="text" placeholder="Nome do livro">
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">format_quote</i>
                        <input id="genre" name="genre" type="text" placeholder="Gênero do livro">
                    </div>
                    <div class="col l6 m6 s6" id="gnrconfbuttons">
                        <a class = "waves-effect waves-light btn orange accent-2" onclick="finishBook()" id="launchbookbutton">Lançar</a>
                    </div>
                </div>
                <div id ="bookcover">
                    <img height="300px" width="300px" src="<?php if($book->cover_path){ echo $book->cover_path;} else{ echo 'serverimages/noimage.png';}?>">
                    <form enctype="multipart/form-data" method="post" action = "" >
                        <input type="file" name="coverupload" id="coverupload" style="display:none">
                        <input type = "submit" onclick="save()" style="display:none" id="bookcoversubmit">
                        <a class="waves-effect waves-light btn green" onclick="$('#coverupload').click()">Escolher Arquivo para capa</a>
                        <a class="waves-effect waves-light btn blue" onclick="$('#bookcoversubmit').click()">Enviar</a>
                    </form>
                </div>


            </div>    
        </div>
        <div class ="modal-footer" class="modal">

        </div>
    </div>
    <div id ="confirmingmodal" class = "modal">
        <div class = "modal-content">
            <div class = "row">
                <i class="material-icons right" class="modal-close">close</i> 
            </div>
            <h3 class="modal-header">Você tem certeza?</h3>
            Após lançado o livro não pode ser mais editado

        </div>
        <div class ="modal-footer" class="modal">
            <a class="left btn green waves-effect waves-light" onclick="launch(true)">Confirmar</a>
            <a class="right btn red waves-effect waves-light" onclick="launch(false)">Cancelar</a>
        </div>
    </div>
    <div id ="confirmingdelmodal" class = "modal">       
        <div class = "modal-content">
            <div class = "row">
                <i class="material-icons right" class="modal-close">close</i> 
            </div>
            <p>Você tem certeza que deseja deletar esse texto?, todos os textos derivados seram deletados.</p>
        </div>
        <div class ="modal-footer" class="modal">
            <a class="btn waves-ripple blue left-align " onclick="confirmDeletion(false)">Cancelar</a>
            <a class="btn waves-ripple red " onclick="confirmDeletion(true)">Deletar</a>
        </div>
    </div>
    
    <div id="textaddmodal" class="modal">
        <div class="modal-content">
            <div class="input-field">
                <label for="newtextid">Nome</label>
                <input type="text" id="newtextname" name="newtextname">
            </div>
        </div>
        <div class="modal-footer">
            <a class="waves-light waves-effect green btn" onclick="createtext()">Criar Texto</a>
        </div>
    </div>
    
</div>