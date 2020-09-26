<?php

class Save {

    public $id;
    public $name;
    public $usertobook_idusertobook;
    public $text_id;

    function __construct($id = NULL) {
        if ($id) {
            $db = new Conexao();
            $sql = 'SELECT * FROM save WHERE id=:id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Save');
            $stmt->execute();
            $save = $stmt->fetch();
            foreach ($save as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function countTexts() {
        $x = 0;
        $text = new Text($this->text_id);
        $x = $this->count($x, $text);
        return $x;
    }

    private function count($x, $text) {
        $x++;
        $newtext = $text->getFather();
        if($newtext){
           $x = $this->count($x,$newtext);
        }
        return $x;
        
    }

    public function save() {
        $db = new Conexao();
        if ($this->id) {
            $sql = 'UPDATE save SET name = :name, text_id = :textid WHERE id = ' . $this->id;
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':textid', $this->text_id);
            $stmt->bindParam(':name', $this->name);
            $stmt->execute();
        } else {
            $sql = 'INSERT INTO save(name,usertobook_idusertobook,text_id) VALUES(:name,:usertobook_id,:text_id)';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':text_id', $this->text_id);
            $stmt->bindParam(':usertobook_id', $this->usertobook_idusertobook);
            $stmt->execute();
        }
    }

    public function delete() {
        $db = new Conexao();
        $db->query('DELETE FROM save WHERE id = ' . $this->id);
    }

}
