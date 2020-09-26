<?php

class createbook {
    /*
     * Exibe os textos, pode s epassar o parametro search para pesquisar os textos por nome.
     */

    public static function showTexts($bookid) {
        $book = new Ibook($bookid);
        $firsttext = $book->getFirstText();
        
        echo '
                   <div class="row textsrow" id="currentrow">
                        <h2>Textos dessa linha da arvore</h2>
                        <div id="selectedtext" class = "textid' . $firsttext->id . ' booktext  blue-grey card accent-1 firsttext col s6 l2 m4" data-id ="' . $firsttext->id . '">
                            <div class="card-content bookex white-text">
                                <span class="card-title">'.$firsttext->name.'</span>
                                
             
                                <p>'. mb_strimwidth($firsttext->text,0,60,'...').'</p>
                            </div>
                            <div class="card-action">
                            <a class="btn textbtn waves-effect waves-light orange accent-1" onClick="showtext(' . $firsttext->id . ')"><i class="material-icons tiny">build</i></a>    
                            <a class="btn textbtn waves-effect waves-light green accent-1"onClick="addtext(' . $firsttext->id . ')" ><i class="material-icons tiny">add_circle</i></a>
                            
                            </div>

                          
                          
                        </div>
                    </div>


                ';
        $texts = $firsttext->getChilds();

        echo '<div class="row textsrow" id="childsrow">';
        echo '<h2>Textos Subsequentes</h2>';
        foreach ($texts as $text) {
            echo '

                        <div class = "textid' . $text->id . ' booktext  grey card accent-1 firsttext col s6 l2 m4" data-id ="' . $text->id . '">
                            <div class="card-content bookex white-text">
                                <span class="card-title">'.$text->name.'</span>
                                
             
                                <p>'. mb_strimwidth($text->text,0,50,'...').'</p>
                            </div>
                            <div class="card-action">
                            <a class="btn textbtn waves-effect waves-light orange accent-1" onClick="showtext(' . $text->id . ')"><i class=" material-icons tiny">build</i></a>    
                            <a class="btn textbtn waves-effect waves-light green accent-1"onClick="addtext(' . $text->id . ')" ><i class="material-icons tiny">add_circle</i></a>
                            <a class="btn textbtn waves-effect waves-light blue accent-1" onClick="selecttext(' . $text->id . ')"><i class="material-icons tiny">eject</i></a>    
                            <a class="btn textbtn waves-effect waves-light red accent-1" onClick="deletetext('.$text->id.')"><i class="material-icons tiny">delete_forever</i></a>
                            </div>

                          
                          
                        </div>


                ';
        }
        echo '</div>';
    }

    public static function changeViewText($textid) {
        
    }

    public static function editText($textid, $bookid) {
        $db = new Conexao();
        $text = new Text($textid);
        echo '<div class="row" >
            <h6>Nome do texto</h6>
            <div class="input-field col s8 m8 l8">
            <input id="textnamebox" name="textnamebox" type="text" class="" placeholder="' . $text->name . '">
            </div>
            </div>
            <div class="row">
                
                <textarea id="texttextarea" style="width:100%">' . $text->text . '</textarea>
                
            </div>
            <input type="hidden" id="textedittextid"value="' . $text->id . '">
        ';
    }

    /*
     * Cria um novo texto
     */

    public static function createText($bookid, $fatherid,$textname) {
        $db = new Conexao();
        $db->query('INSERT INTO text(ibook_id,text_id,name) VALUES(' . $bookid . ',' . $fatherid . ',"'.$textname.'")');
        $r = $db->query('SELECT * FROM text ORDER BY id DESC LIMIT 1');
        $r->setFetchMode(PDO::FETCH_CLASS, 'Text');
        $text = $r->fetch();
        echo '
            <div class = "textid' . $text->id . ' booktext  grey card accent-1 firsttext col s6 l2 m4" data-id ="' . $text->id . '">
                            <div class="card-content white-text bookex">
                                <span class="card-title">'.$text->name.'</span>
                                
             
                                <p>'. mb_strimwidth($text->text,0,50,'...').'</p>
                            </div>
                            <div class="card-action">
                            <a class="btn textbtn waves-effect waves-light orange accent-1" onClick="showtext(' . $text->id . ')"><i class="material-icons tiny">build</i></a>    
                            <a class="btn textbtn waves-effect waves-light green accent-1"onClick="addtext(' . $text->id . ')" ><i class="material-icons tiny">add_circle</i></a>
                            <a class="btn textbtn waves-effect waves-light blue accent-1" onClick="selecttext(' . $text->id . ')"><i class="material-icons tiny">eject</i></a>    
                            <a class="btn textbtn waves-effect waves-light red accent-1" onClick="deletetext('.$text->id.')"><i class="material-icons tiny">delete_forever</i></a>
                            </div>

                          
                          
                        </div>
        ';
    }

    /*
     * Exibe painel para criação de variaveis.
     */

    /*
     * Seleciona textos e os arranja dinamicamente.
     */

    public static function selectText($textid, $bookid) {
        $selectedtext = new Text($textid);
        $fathertext = $selectedtext->getFather();
        $childs = $selectedtext->getChilds();
        if ($selectedtext->id != $selectedtext->text_id) {
            $equals = $fathertext->getChilds();
        }

        if ($fathertext) {
            echo'<div class="row textsrow  lighten-3" id="fatherrow">'
            . '<h2>Texto Pai</h2>';
            echo '<div class = "textid' . $fathertext->id . ' booktext  grey card accent-1 firsttext col s6 l2 m4" data-id ="' . $fathertext->id . '">
                            <div class="card-content bookex white-text">
                                <span class="card-title">'.$fathertext->name.'</span>
                                
             
                                <p>'. mb_strimwidth($fathertext->text,0,60,'...').'</p>
                            </div>
                            <div class="card-action">
                            <a class="btn textbtn waves-effect waves-light orange accent-1" onClick="showtext(' . $fathertext->id . ')"><i class="material-icons tiny">build</i></a>    
                            <a class="btn textbtn waves-effect waves-light green accent-1"onClick="addtext(' . $fathertext->id . ')" ><i class="material-icons tiny">add_circle</i></a>
                            <a class="btn textbtn waves-effect waves-light blue accent-1" onClick="selecttext(' . $fathertext->id . ')"><i class="material-icons tiny">eject</i></a>    
                            <a class="btn textbtn waves-effect waves-light red accent-1" onClick="deletetext('.$fathertext->id.')"><i class="material-icons tiny">delete_forever</i></a>
                            </div>

                          
                          
                        </div>
                   ';
            echo'</div>';
        }
        else{
            echo '<div class="row textsrow  lighten-3" id="currentrow">'
            . '<h2>Texto Inicial</h2>';
            echo '<div id="selectedtext" class = "textid' . $selectedtext->id . ' booktext  blue-grey card accent-1 firsttext col s6 l2 m4" data-id ="' . $selectedtext->id . '">
                            <div class="card-content bookex white-text">
                                <span class="card-title">'.$selectedtext->name.'</span>
                                
             
                                <p>'. mb_strimwidth($selectedtext->text,0,60,'...').'</p>
                            </div>
                            <div class="card-action">
                            <a class="btn textbtn waves-effect waves-light orange accent-1" onClick="showtext(' . $selectedtext->id . ')"><i class="material-icons tiny">build</i></a>    
                            <a class="btn textbtn waves-effect waves-light green accent-1"onClick="addtext(' . $selectedtext->id . ')" ><i class="material-icons tiny">add_circle</i></a>
                                
                            </div>

                          
                          
                        </div>';
            echo'</div>';
        }
        if ($selectedtext->id != $selectedtext->text_id) {
            echo '<div class="row textsrow  lighten-3" id="currentrow">'
            . '<h2>Textos dessa linha</h2>';

            foreach ($equals as $e) {
                if ($e->id == $selectedtext->id) {
                    echo '<div id="selectedtext" class = "textid' . $e->id . ' booktext  blue-grey card accent-1 firsttext col s6 l2 m4" data-id ="' . $e->id . '">
                            <div class="card-content bookex white-text">
                                <span class="card-title">'.$e->name.'</span>
                                
             
                                <p>'. mb_strimwidth($e->text,0,60,'...').'</p>
                            </div>
                            <div class="card-action">
                            <a class="btn textbtn waves-effect waves-light orange accent-1" onClick="showtext(' . $e->id . ')"><i class="material-icons tiny">build</i></a>    
                            <a class="btn textbtn waves-effect waves-light green accent-1"onClick="addtext(' . $e->id . ')" ><i class="material-icons tiny">add_circle</i></a>
                            <a class="btn textbtn waves-effect waves-light red accent-1" onClick="deletetext('.$e->id.')"><i class="material-icons tiny">delete_forever</i></a>
                            </div>

                          
                          
                        </div>';
                    continue;
                    
                }
                echo '<div class = "textid' . $e->id . ' booktext  grey card accent-1 firsttext col s6 l2 m4" data-id ="' . $e->id . '">
                            <div class="card-content bookex white-text">
                                <span class="card-title">'.$e->name.'</span>
                                
             
                                <p>'. mb_strimwidth($e->text,0,60,'...').'</p>
                            </div>
                            <div class="card-action">
                            <a class="btn textbtn waves-effect waves-light orange accent-1" onClick="showtext(' . $e->id . ')"><i class="material-icons tiny">build</i></a>    
                            <a class="btn textbtn waves-effect waves-light green accent-1"onClick="addtext(' . $e->id . ')" ><i class="material-icons tiny">add_circle</i></a>
                            <a class="btn textbtn waves-effect waves-light blue accent-1" onClick="selecttext(' . $e->id . ')"><i class="material-icons tiny">eject</i></a>    
                            <a class="btn textbtn waves-effect waves-light red accent-1" onClick="deletetext('.$e->id.')"><i class="material-icons tiny">delete_forever</i></a>
                            </div>

                          
                          
                        </div>
                   ';
                
            }
            

            echo'</div>';
        }
        echo '<div class="row textsrow  lighten-3" id="childsrow">';
        if($childs){
            echo '<h2>Textos Subsequentes</h2>';
        
        }
        foreach ($childs as $c) {
            echo '<div class = "textid' . $c->id . ' booktext  grey card accent-1 firsttext col s6 l2 m4" data-id ="' . $c->id . '">
                            <div class="card-content bookex white-text">
                                <span class="card-title">'.$c->name.'</span>
                                
             
                                <p>'. mb_strimwidth($c->text,0,60,'...').'</p>
                            </div>
                            <div class="card-action">
                            <a class="btn textbtn waves-effect waves-light orange accent-1" onClick="showtext(' . $c->id . ')"><i class="material-icons tiny">build</i></a>    
                            <a class="btn textbtn waves-effect waves-light green accent-1"onClick="addtext(' . $c->id . ')" ><i class="material-icons tiny">add_circle</i></a>
                            <a class="btn textbtn waves-effect waves-light blue accent-1" onClick="selecttext(' . $c->id . ')"><i class="material-icons tiny">eject</i></a>    
                            <a class="btn textbtn waves-effect waves-light red accent-1" onClick="deletetext('.$c->id.')"><i class="material-icons tiny">delete_forever</i></a>
                            </div>

                          
                          
                        </div>
                   ';
        }
        echo '</div>';
    }

    public static function showVariableControl($ibookid) {
        
    }

    /*
     * Mostra painel de exibição de relações de texto variavel.
     */

    public static function showVariableRelationships($ibookid) {
        
    }

    /*
     * Exibe as alternativas de um texto
     */

    public static function showTextAlternatives($textid) {
        
    }

    /*
     * Mostra as condições necessarias para a exibição do texto.
     */

    public static function showTextConditions($textid) {
        
    }

}
