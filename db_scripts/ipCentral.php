<?php


$codevento = $_REQUEST['CodEvento'];

$user = 'u716496248_alvar';
$DB = 'u716496248_alvar';
$pass = 'alvaro';

try {
    $mbd = new PDO("mysql:host=localhost;dbname=" . $DB, $user, $pass);

} catch (PDOException $e) {
    $msg = 1;// Error de conexion con la BD
    echo "Error:" . $e->getMessage();
    exit;
}

// header("Content-Type:application/json");
$stmt = $mbd->prepare("SELECT IpPantalla FROM PANTALLA WHERE codEvento = ? AND codPantalla = ?");
$stmt->execute(array($codevento, 'R0'));
$ip = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($ip) > 0) {

    //$info = array($ip["IpPantalla"] = [$ip["IpPantalla"]]);
    $info['Msg'] = 2;
    $info['IpPantalla'] = $ip[0]["IpPantalla"];


} else {//No existen pantallas registradas para ese evento
    $info = array('Msg' => 3);

}

echo json_encode($info, JSON_NUMERIC_CHECK);
return json_encode($info);





