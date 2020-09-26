<?php

class Text {
    public $id;
    public $text;
    public $name;
    public $ibook_id;
    public $text_id;
    
    function __construct($id = NULL){
        if($id){
            $db = new Conexao();
            $sql ='SELECT * FROM text WHERE id=:id';
            $stmt =  $db->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Text');
            $stmt->execute();
            $text = $stmt->fetch();
            foreach($text as $key => $value){
                $this->$key = $value;
            }
	}
    }
    
    
    
    public function delete(){
        $db= new Conexao();
        $db->query('DELETE FROM text WHERE id = '.$this->id);
    }
    public function save(){
        $db = new Conexao();
        if($this->id){
            $sql = 'UPDATE text SET text = :text , name = :name, text_id = :text_id WHERE id=:id';
            $stmt =$db->prepare($sql);
            $stmt->bindParam(':id',$this->id);
            $stmt->bindParam(':text', $this->text);
            $stmt->bindParam(':name',$this->name);
            $stmt->bindParam(':text_id',$this->text_id);
            $stmt->execute();
        }
        else{
            $sql = 'INSERT INTO text(text,name,ibook_id,text_id) VALUES(:text,:name,:ibook_id,:text_id)';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':text_id',$this->text_id);
            $stmt->bindParam(':text', $this->text);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':ibook_id',$this->ibook_id);
            $stmt->execute();
        }
    }
    //retorna seções filha dessa seção.
    public function getChilds(){
        $db = new Conexao();
        $rs = $db->query('SELECT * FROM text WHERE text_id = '.$this->id.' AND text_id != id');
        $rs->setFetchMode(PDO::FETCH_CLASS, 'Text');
        $texts = $rs->fetchAll();
        return $texts;
    }
    //retrna seção pai dessa seção, caso a sessão seja a primeira retorna "false"
    public function getFather(){
        
        if($this->text_id == $this->id){
            return false;
        }
        $db = new Conexao();
        $rs = $db->query('SELECT * FROM text WHERE id = '.$this->text_id);
        $rs->setFetchMode(PDO::FETCH_CLASS, 'Text');
        $text = $rs->fetch();
        return $text;
    } 
    //Sem certeza do porque dessa função, ela não vai ser usada em nenhuma situação.
    public function getBook(){
        $book = new Ibook($this->ibook_id);
        return $book;
    }
}
