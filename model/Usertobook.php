<?php

class Usertobook {
    public $idusertobook;
    public $isfavorite;
    public $user_id;
    public $ibook_id;
    
    function __construct($id = NULL){
        if($id){
            $db = new Conexao();
            $sql ='SELECT * FROM usertobook WHERE id=:id';
            $stmt =  $db->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usertobook');
            $stmt->execute();
            $ustbo = $stmt->fetch();
            foreach($ustbo as $key => $value){
                $this->$key = $value;
            }
	}
    }
    
    public static function getlistFromUser($userid){
        if($userid == null){
            return false;
        }
        $db = new Conexao();
        $rs = $db->query('SELECT * FROM usertobook WHERE user_id = '.$this->user_id);
        $rs->setFetchMode(PDO::FETCH_CLASS,'Usertobook');
        $ustbos = $rs->fetchAll();
        return $ustbos;
    }
    
    public function delete(){
        $db = new Conexao();
        $db->query('DELETE FROM usertobook WHERE id = '.$this->id);
    }
    
    public function save(){
        $db = new Conexao();
        if($this->idusertobook){
            $sql = "UPDATE usertobook SET isfavorite = :isfavorite WHERE id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id',$this->id);
            $stmt->bindParam(':isfavorite',$this->favorite);
            $stmt->execute();
        }
        else{
            $sql = 'INSERT INTO usertobook(isfavorite, user_id, ibook_id) VALUES( :isfavorite, :user_id, :ibook_id)';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':isfavorite',$this->isfavorite);
            $stmt->bindParam(':ibook_id',$this->ibook_id);
            $stmt->bindParam(':user_id', $this->user_id);
            $stmt->execute();
        }
    }
    //Pega arquivso de gravação do usuario
    public function getSaves(){
        $db = new Conexao();
        $sql = "SELECT * FROM save WHERE usertobook_id = ".$this->id;
        $rs = $db->query($sql);
        $rs->setFetchMode(PDO::FETCH_CLASS,'Save');
        $saves = $rs->fetchAll();
        return $saves;
    }
}
