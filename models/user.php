<?php
include_once 'db.php';

class User {
    private $db;
    private $nombre;
    //private $username;

    public function __construct(){
        $this->db=DB::connect();
    }

    public function userExists($user, $pass){
        $md5pass = md5($pass);
        $stmt = $this->db->prepare('SELECT * FROM ADMIN WHERE nombreAdmin = :user AND contraAdmin = :pass');
        $stmt->execute(['user' => $user, 'pass' => $md5pass]);

        if($stmt->rowCount()){
            return true;
        }else{
            return false;
        }
    }

    public function setUser($user){
        $stmt = $this->db->prepare('SELECT * FROM ADMIN WHERE nombreAdmin = :user');
        $stmt->execute(['user' => $user]);

        foreach ($stmt as $currentUser) {
            $this->nombre = $currentUser['NombreAdmin'];
           // $this->username = $currentUser['username'];
        }
    }

    public function getNombre(){
        return $this->nombre;
    }
}

?>
