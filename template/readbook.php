<script src="template/js/rebook.js"></script>
<?php
$bookid = filter_input(INPUT_GET, 'bookid', FILTER_SANITIZE_NUMBER_INT);
if (!isset($_SESSION['userid'])) {
    header('Locaiton:index.php?page=login');
}
$book = new Ibook($bookid);
$db = new Conexao();
$sql = "SELECT * FROM usertobook WHERE user_id = :user_id AND ibook_id = :ibook_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION['userid']);
$stmt->bindParam(':ibook_id', $bookid);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Usertobook');
$r = $stmt->fetch();
if ($r->idusertobook) {
    
} else {
    $usertobook = new Usertobook();
    $usertobook->ibook_id = $bookid;
    $usertobook->user_id = $_SESSION['userid'];
    $usertobook->save();
}
?>
<style>
    body{
        overflow:hidden;
    }
</style>
<div id="bookread" class="clear row"data-bookid="<?php echo $bookid ?>">
    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper orange">
                <a class="brand-logo center"><?php echo $book->name ?></a>
                <ul class="left hide-on-med-and-down">
                    <li><a class="btn waves-light waves-effect green" onclick="openData()">Dados Salvos</a></li>
                    <li><a href="index.php?page=booklist">Voltar para lista de livros</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="orange lighten-4 col m4 l4 hide-on-small-only" id="historic">
        <h2 id="historic-header">Histórico</h2>
        <div id ="historic-content">
            
        </div>
    </div>
    <div id="bookcontainer" class="col m8 l8">
        
    </div>
    <!--Modals da página -->
    <div id="savesmodal" class="modal" data-userid="<?php echo $_SESSION['userid'] ?>">
        <h3 class="modal-header center-align">Dados salvos</h3>
        <div class = "modal-content" id="saves">

        </div>
        <div class = modal-footer>
            <a class="waves-light waves-effect green btn" onclick="makeSave()">Adicionar dados salvos</a>
        </div>
    </div>
    <div id = "createsavemodal" class="modal">

        <div class="modal-content">
            <h3 class="center-align">Nome do arquivo de save</h3>
            <div class="input-field" id="savenameinputfile">
                <input placeholder="" id="savefilename" name="savefilename" class="validate" type="text">
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn waves-light waves-effect red btn left-align" onclick="createSave(false)">Cancelar</a>
            <a class="btn waves-light waves-effect green btn right-align"onclick="createSave(true)">Criar dados salvos</a>
        </div>
    </div>
    <!-- A secret to everyone <a class="waves-effect waves-light btn"onClick="openData()">Dados salvos</a>
        <a class ="waves-light waves-effect btn" href="index.php">Voltar</a> 
        <div class="row" id="rebooknavbar">
        
    </div>
    <div class="clear"></div>
    <div id ="bookcontainer" class="clear row"></div>
    
    -->
</div>
