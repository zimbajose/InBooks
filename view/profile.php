<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of profile
 *
 * @author Jose
 */
class profile {

    public static function getunreleasedbooks($userid) {
        $user = new User($userid);
        $books = $user->getBooks();
        foreach ($books as $book) {
            if ($book->released != 1) {
                if ($book->cover_path) {
                    $coverpath = $book->cover_path;
                } else {
                    $coverpath = "serverimages/noimage.png";
                }
                echo '
                    <div class="bookpanel col s12 m12 l6 yellow lighten-1 panel" onmouseenter="showUnReData('.$book->id.')">
                        <div class="imgcover"><img height="130px" width="130px" class="bookcover left-align" src="' . $coverpath . '"></div>
                         <div class="bookinfo">
                         <h3 class="panel-header bookname center">' . $book->name . '</h3>
                         <h5 class="bookgenre left-align">' . $book->genre . '</h5>
                         <a class="btn waves-light waves-effect light-yellow lighten-2" href="index.php?page=cebook&book=' . $book->id . '">Editar livro</a>
                         <a class="btn waves-light waves-effect red"onclick="deletebook('.$book->id.')">Deletar</a>    
                         </div>
                    </div>
                ';
            }
        }
        echo '<div class="bookpanel col s12 m12 l6 panel yellow lighten-5">
                <div class="imgcover"><i class="material-icons" height="130px" width="130px" class="bookcover"onclick="addBook()">add_box</i></div>
                <h3 class="panel-header bookname center">Criar novo livro</h3>
                
              </div>
            
        ';
    }

    public static function getreadingbooks($userid) {
        $db = new Conexao();
        $sql = 'SELECT i.* FROM ibook i, usertobook utb WHERE i.id = utb.Ibook_id AND utb.user_id = :userid ';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':userid', $userid);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Ibook');
        $books = $stmt->fetchAll();

        foreach ($books as $book) {

            if ($book->cover_path) {
                $coverpath = $book->cover_path;
            } else {
                $coverpath = "serverimages/noimage.png";
            }
            echo '
                    <div class="bookpanel col s12 m12 l6 yellow lighten-1 panel" onmouseenter="showReadingData('.$book->id.')" >
                        <div class="imgcover"><img height="130px" width="130px" class="bookcover left-align" src="' . $coverpath . '"></div>
                         <div class="bookinfo">
                         <h3 class="panel-header bookname center">' . $book->name . '</h3>
                         <h5 class="bookgenre left-align">' . $book->genre . '</h5>
                         <a class="btn waves-light waves-effect orange lighten-2" href="index.php?page=rebook&bookid=' . $book->id . '">Ler</a>    
                         </div>
                    </div>
                ';
        }
    }
    
    public static function showreadingbook($book, $user){
        $save  = $user->getSave($book->id);
        if($save){
            $lasttext = new Text($save->text_id);
            $pagecount = $save->countTexts();
        }
        if($book->cover_path == ''){
            $coverpath = "serverimages/noimage.png";
        }
        else{
            $coverpath = $book->cover_path;
        }
        echo '
            <h3 class="booktitle">'.$book->name.'</h3>
            <div class="bookinfoimgdiv"><img src="'.$coverpath.'" class="bookinfoimg"></div>      
        ';
        if($save){
            echo'<h3 class="lasttext">Ultimo texto foi:'.$lasttext->name.'</h3>';
            echo '<h3 class="pagecount">Você já leu:'.$pagecount.' Paginas</h3>';
        }
        else{
            echo '<h3 class="bookalert">Não há dados salvos sobre esse livro</h3>';
        }
    }
    
    public static function showunreleasedbook($book,$user){
        $textcount = $book->countTexts();
        $endingcount = $book->countEndings();
         if($book->cover_path == ''){
            $coverpath = "serverimages/noimage.png";
        }
        else{
            $coverpath = $book->cover_path;
        }
        echo '
            <h3 class="booktitle">'.$book->name.'</h3>
            <div class="bookinfoimgdiv"><img src="'.$coverpath.'" class="bookinfoimg"></div>      
            <h3 class="textcount">Numero de textos:'.$textcount.'</h3>
            <h3 class="endingcount">Numero de finais:'.$endingcount.'</h3>    
        ';
    }
    
    
    
    public static function showreleasedbook($book,$user){
        $viewcount = $book->getViews();
        if(!$viewcount){
            $viewcount = '0 :(';
        }
        if($book->cover_path == ''){
            $coverpath = "serverimages/noimage.png";
        }
        else{
            $coverpath = $book->cover_path;
        }
        echo '
            <h3 class="booktitle">'.$book->name.'</h3>
            <div class="bookinfoimgdiv"><img src="'.$coverpath.'" class="bookinfoimg"></div>      
            <h3 class="viewcount">Visualizações: '.$viewcount.'</h3>
        ';
    }
    
    public static function getreleasedbooks($userid) {
        $user = new User($userid);
        $books = $user->getBooks();
        foreach ($books as $book) {
            if ($book->released == 1) {
                if ($book->cover_path) {
                    $coverpath = $book->cover_path;
                } else {
                    $coverpath = "serverimages/noimage.png";
                }
                echo '
                    <div class="bookpanel col s12 m12 l6 orange lighten-1 panel" onmouseenter="showReData('.$book->id.')">
                        <div class="imgcover"><img height="100px" width="100px" class="bookcover left-align" src="' . $coverpath . '"></div>
                         <div class="bookinfo">
                         <h3 class="panel-header bookname center">' . $book->name . '</h3>
                         <h5 class="bookgenre left-align">' . $book->genre . '</h5>    
                         <a class="btn waves-light waves-effect red"onclick="deletebook('.$book->id.')">Deletar</a>    
                         </div>
                    </div>
                ';
            }
        }
    }

}
