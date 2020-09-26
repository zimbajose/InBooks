<?php
class User{
  public $id;
  public $username;
  public $email;
  public $password;


	/*
	*Cria uma istância de User ou Bysca um clientena base de dados
	*@param int $id
	*/
	function __construct($id = NULL){
		if($id){
			$db = new Conexao();
			$sql ='SELECT * FROM user WHERE id=:id';
			$stmt =  $db->prepare($sql);
			$stmt->bindParam(':id',$id);
			$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
                        $stmt->execute();
			$cliente = $stmt->fetch();
			foreach($cliente as $key => $value){
				$this->$key = $value;
			}
		}
	}

	
	public static function getList(){
		$db = new Conexao();
		$sql = 'SELECT * FROM user ORDER BY nome';
		$rs = $db->query($sql);
                $rs->setFetchMode(PDO::FETCH_CLASS,'User');
		$users = $rs->fetchAll();
		return $users;
	}




	public function save(){
		$db = new Conexao();
		if($this->id){
			//update
			$sql = 'UPDATE user SET username= :username, email=:email, password=:password WHERE id='.$this->id;
			$stmnt = $db->prepare($sql);
			$stmnt->bindParam(':username',$this->username);
			$stmnt->bindParam(':email',$this->email);
			$stmnt->bindParam(':password',$this->password);
			return $stmnt->execute();

		}
		else{
			//insert
			$sql = 'INSERT INTO user(username, email ,password) VALUES(:username,:email,:password)';
			$stmnt = $db->prepare($sql);
			$stmnt->bindParam(':username',$this->username);
			$stmnt->bindParam(':email',$this->email);
			$stmnt->bindParam(':password',$this->password);
			return $stmnt->execute();

		}
	}

	public function delete(){
		$db = new Conexao();
		$sql = 'DELETE FROM FROM user WHERE id='.$this->id;
		$rs =$db->query($sql);
		return $rs->execute();
	}
        
        
        
        public static function checkEmail($email){
            $db = new Conexao();
            $sql = 'SELECT * FROM user WHERE email = :email';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email',$email);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS,'User');
            $temp = $stmt->fetch();
            if(isset($temp->id)){
                return false;
            }
            else{
                return true;
            }
        }
        
         public static function login($email, $password){
            $db = new Conexao();
            $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':password',$password);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $stmt->execute();
            $temp = $stmt->fetch();
            if($temp->id){
                return $temp->id;
            }
            else{
                return false;    
            }
  }
  public function getBooks(){
      $db = new Conexao();
      $sql = 'SELECT * FROM ibook WHERE user_id = :id';
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id',$this->id);
      $stmt->setFetchMode(PDO::FETCH_CLASS,'Ibook');
      $stmt->execute();
      $ibooks = $stmt->fetchAll();
      return $ibooks;
  }
  
  public function getSaves($bookid){
      $db = new Conexao();
      $sql = "SELECT s.* FROM saves s , usertobook utb WHERE s.usertobookid_idusertobook = utb.idusertobook AND utb.ibook_id = :bookid AND utb.user_id = :userid";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':bookid',$bookid);
      $stmt->bindParam(':userid',$this->id);
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_CLASS,'Save');
      $saves = $stmt->fetchAll();
      return $saves;    
      
  }
  public function getSave($bookid){
      $db = new Conexao();
      $sql = "SELECT s.* FROM save s , usertobook utb WHERE s.usertobook_idusertobook = utb.idusertobook AND utb.ibook_id = :bookid AND utb.user_id = :userid";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':bookid',$bookid);
      $stmt->bindParam(':userid',$this->id);
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_CLASS,'Save');
      $save = $stmt->fetch();
      return $save;    
      
  }
  
}
