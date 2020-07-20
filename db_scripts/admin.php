<?php

$admin = $_REQUEST['admin'];
$password = $_REQUEST['password'];


$user = 'u716496248_alvar';
$DB = 'u716496248_alvar';
$pass = 'alvaro';


try {
    $mbd = new PDO("mysql:host=localhost;dbname=" . $DB, $user, $pass);

}catch(PDOException $e){
    $msg = 1;// Error de conexion con la BD
    echo "Error:". $e->getMessage();
    echo json_encode($msg);
    return json_encode($msg);
    exit;
}


$md5pass = md5($password);
$stmt = $mbd->prepare('SELECT codEvento FROM ADMIN WHERE nombreAdmin = :user AND contraAdmin = :pass');
$stmt->execute(['user' => $admin, 'pass' => $md5pass]);
$fetch = $stmt->fetch(PDO::FETCH_ASSOC);

$admin = array();

$admin = $fetch;
if($stmt->rowCount()){
    $admin["msg"] =  2;
}else{
    $admin["msg"] =  3;
}


echo json_encode($admin);
return json_encode($admin);