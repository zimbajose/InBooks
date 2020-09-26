<?php


class Ibook {
    public $id;
    public $released;
    public $name;
    public $genre;
    public $cover_path;
    public $user_id;

    function __construct($id = NULL){
		if($id){
			$db = new Conexao();
			$sql ='SELECT * FROM ibook WHERE id=:id';
			$stmt =  $db->prepare($sql);
			$stmt->bindParam(':id',$id);
			$stmt->setFetchMode(PDO::FETCH_CLASS, 'Ibook');
                        $stmt->execute();
			$ibook = $stmt->fetch();
			foreach($ibook as $key => $value){
				$this->$key = $value;
			}
		}
    }
    
    public static function getlist(){
        $db = new Conexao();
        $sql = "SELECT * FROM ibook ORDER BY name";
        $rs = $db->query($sql);
        $rs->setFetchMode(PDO::FETCH_CLASS,'Ibook');
        $ibooks = $rs->fetchAll();
        return $ibooks;
        
        
    }
    
    public function getTexts(){
        $db = new Conexao();
        $sql = 'SELECT * FROM text WHERE ibook_id = '.$this->id.'';
        $rs = $db->query($sql);
        $rs->setFetchMode(PDO::FETCH_CLASS, 'Text');
        $texts = $rs->fetchAll();
        return $texts;
    }
    
    public function getFirstText(){
        $db = new Conexao();
        $sql = 'SELECT * FROM text WHERE ibook_id = :id AND id = text_id ';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id',$this->id);
        $stmt->execute();      
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Text');
        $texts = $stmt->fetch();
        return $texts;
    }
    
    
    public function save(){
        $db = new Conexao();
        if($this->id){
           $sql = 'UPDATE ibook SET released = :released, name =:name , genre = :genre, cover_path = :cover_path WHERE id = :id';
           $stmt = $db->prepare($sql);
           $stmt->bindParam(':id',$this->id);
           $stmt->bindParam(':name',$this->name);
           $stmt->bindParam(':released', $this->released);
           $stmt->bindParam(':genre',$this->genre);
           $stmt->bindParam(':cover_path',$this->cover_path);
           return $stmt->execute();
        }    
        else{
            $sql ='INSERT INTO ibook(name,genre,released,user_id,cover_path) VALUES(:name,:genre,:released,:userid,:coverpath)';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':name',$this->name);
            $stmt->bindParam(':released',$this->released);
            $stmt->bindParam(':genre',$this->genre);
            $stmt->bindParam(':userid',$this->userid);
            $stmt->bindParam(':coverpath',$this->cover_path);
            return $stmt->execute();
        }
        
    }
    
    public function getViews(){
        $db = new Conexao();
        $sql = "SELECT count(utb.idusertobook) AS ic FROM ibook i, usertobook utb WHERE utb.ibook_id = :bookid GROUP BY(i.id)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':bookid',$this->id);
        $stmt->execute();
        $r = $stmt->fetch();
       
        return $r['ic'];
    }
    
    public function countTexts(){
        $db = new Conexao();
        $sql = "SELECT count(id) AS ic FROM text WHERE ibook_id = :bookid";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':bookid',$this->id);
        $stmt->execute();
        $r = $stmt->fetch();
        
        return $r['ic'];
    }
    public function countEndings(){
        $db = new Conexao();
        $sql = "SELECT count(id) AS ic FROM text WHERE ibook_id=:bookid AND id NOT IN(SELECT text_id FROM text WHERE ibook_id = :bookid)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':bookid',$this->id);
        $stmt->execute();
        $r = $stmt->fetch();
        
        return $r['ic'];
    }
    
    public function delete(){
        $db = new Conexao();
        $db->query("DELETE FROM ibook WHERE id = ".$this->id);
    }
    
    public function getUser(){
        $user = new User($this->user_id);
        return $user;
    }
    
    
}
