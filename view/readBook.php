<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of readBook
 *
 * @author Jose
 */
class readBook {
   
    public static function showText($text){
        echo '
            <div id = "booktext" data-textid = "'.$text->id.'">
            <h1 class="booktitle">'.$text->name.'</h1>
                <p>'.$text->text.'</p>
            </div>
            <div id ="bookchoices">
            ';
            $childs = $text->getChilds();
            if(!$childs){
                echo'<h2 class="bookend">Fim do livro</h2>';
            }
            foreach($childs as $c){
                echo '<div class="choicebox" onClick="chooseText('.$c->id.')"><h3 class="choice" >'.$c->name.'</h3></div>';
                
            }
            echo '</div>';
        
    }
    
    
    public static function getSaves($user, $book){
        $db = new Conexao();
        $sql = "SELECT * FROM usertobook WHERE user_id = :user_id AND ibook_id = :ibook_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':user_id',$user->id);
        $stmt->bindParam(':ibook_id',$book->id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Usertobook');
        $r = $stmt->fetch();
        $sql = "SELECT * FROM save WHERE usertobook_idusertobook = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id',$r->idusertobook);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Save');
        $saves = $stmt->fetchAll();
        foreach($saves as $save){
            $text = new Text($save->text_id);
            $textname = $text->name;
            echo '<div class="savedata row">
                    <div class="savename col s5 m5 l5">'.$save->name.'</div>
                    <a class="waves-light waves-effect green btn "onclick="save('.$save->id.')">Salvar</a>
                    <a class="waves-light waves-ripple btn red "onclick="deleteSave('.$save->id.')">Deletar</a>
                    <a class="waves-light waves-ripple btn orange "onclick="load('.$save->text_id.')">Carregar</a>
                    <div class = "savepoint col s4 l4 m4 grey-text">'.$textname.'</div>    
                 </div>
            ';
            
        }
        
    }
    
}
