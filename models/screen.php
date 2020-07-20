<?php
include_once 'db.php';

class Screen{
    private $screen;
    private $codEvento;
    private $ipPantalla;
    private $db;
    //private $username;

    public function __construct(){
        $this->db=DB::connect();
    }

    public function setIpCentral($codEvento){
        $stmt = $this->db->prepare('SELECT ipPantalla FROM PANTALLA WHERE codEvento = ? AND codPantalla = ?');
        $stmt->execute(array( $codEvento, 'R0'));


        if($fetch = $stmt->fetch(PDO::FETCH_ASSOC)){
            $this->ipPantalla =  $fetch['ipPantalla'];
            $_SESSION['ip'] = $this->ipPantalla;
        }


    }

    public function setCodEvento($admin,$pass){
        $md5pass = md5($pass);
        $stmt = $this->db->prepare('SELECT codEvento FROM ADMIN WHERE nombreAdmin = :admin AND contraAdmin = :pass');
        $stmt->execute(['admin' => $admin, 'pass' => $md5pass]);
        if($fetch= $stmt->fetch(PDO::FETCH_ASSOC)){
            $this->codEvento = $fetch["codEvento"];
        }

    }

    public function getIpCentral(){
        return $this->ipPantalla;
    }

    public function getCodEvento(){
        return $this->codEvento;
    }
}

?>
