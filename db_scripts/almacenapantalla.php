<?php

if(!isset($_GET['CodEvento']) OR !isset($_GET['CodPantalla']) OR !isset($_GET['IpPantalla']) OR !isset($_GET['NomPantalla']) ){
    $msg = -1;// no se han enviado todos los campos en la peticion GET
    echo json_encode($msg);
    return json_encode($msg);

}

$codevento = $_GET['CodEvento'];
$codpantalla = $_GET['CodPantalla'];
$ippantalla = $_GET['IpPantalla'];
$nompantalla = $_GET['NomPantalla'];

echo $codevento;
echo $codpantalla;
echo $ippantalla;
echo $nompantalla;

$user = 'u716496248_alvar';
$DB = 'u716496248_alvar';
$pass = 'alvaro';



if(strlen($codevento )> 15 || strlen($codpantalla) > 3 || substr($codpantalla , 0, 1) !="R" || strlen($nompantalla ) > 40){
    $msg = 0;// Los datos a insertar no cumplen la especificacion de los atributos de la base de datos
    echo json_encode($msg);
    return json_encode($msg);

}

try {
    $mbd = new PDO("mysql:host=localhost;dbname=" . $DB, $user, $pass);

}catch(PDOException $e){
    $msg = 1;// Error de conexion con la BD
    echo "Error:". $e->getMessage();
    echo json_encode($msg);
    return json_encode($msg);
    exit;
}

$sth = $mbd->prepare("SELECT * FROM PANTALLA WHERE CodEvento=? AND (CodPantalla=? OR IpPantalla=?)");
$sth->execute(array($codevento,$codpantalla,$ippantalla));

$pantalla = $sth->fetchAll(PDO::FETCH_ASSOC);

if (count($pantalla) == 0) {//Si NO existe un equipo con el codigo y evento a insertar, se inserta
    try {
        $mbd->beginTransaction();
        $sth = $mbd->prepare("INSERT INTO PANTALLA VALUES(?,?,?,?)");

        if ($sth->execute(array($codevento, $codpantalla, $ippantalla, $nompantalla))) {
            $mbd->commit();
            $msg = 2; //exito
        } else {
            $msg = 3; //error en el insert
        }

    } catch (Exception $e) {
        $msg = 4; //excepcion
    }

    //Si ya existe una entrada analizamos si ha cambiado algun campo
}elseif(count($pantalla) == 1){

    //si lo unico que ha cambiado ha sido el nombre de la pantalla, actualizamos su nombre
    if($pantalla[0]["IpPantalla"] == $ippantalla AND $pantalla[0]["CodPantalla"] == $codpantalla AND $pantalla[0]["NomPantalla"] != $nompantalla) {
        $sth = $mbd->prepare("UPDATE PANTALLA SET NomPantalla=? WHERE CodEvento=? AND CodPantalla=?");
        $actualizar = $sth->execute(array($nompantalla, $codevento, $codpantalla));
        if ($actualizar == TRUE) {
            $msg = 5; //actualizado correctamente el nombre de la pantalla
        } else {
            $msg = 6; //hubo un error al actualizar el nombre
        }
    }
        //Si los datos siguen igual no se hace nada
    if($pantalla[0]["IpPantalla"] == $ippantalla AND $pantalla[0]["CodPantalla"] == $codpantalla AND $pantalla[0]["NomPantalla"] == $nompantalla){

    $msg = 7;//Los datos de la pantalla ya estaban en la BD correctamente

    //Si YA existe el equipo para ese evento, pero con una ip diferente, actualizamos su nueva ip privada
    } elseif($pantalla[0]["IpPantalla"] != $ippantalla AND $pantalla[0]["CodPantalla"] == $codpantalla){

        $sth = $mbd->prepare("UPDATE PANTALLA SET IpPantalla=? WHERE CodEvento=? AND CodPantalla=?");
        $actualizar = $sth->execute(array($ippantalla, $codevento, $codpantalla));
        if ($actualizar == TRUE) {
            $msg = 8; //actualizada correctamente la ip
        } else {
            $msg = 9; //no se ha actualizado la ip
        }

    }
    elseif($pantalla[0]["IpPantalla"] == $ippantalla AND $pantalla[0]["CodPantalla"] != $codpantalla){//Si YA existe el equipo para ese evento, pero con un codigo diferente, actualizamos su codigo
        $sth = $mbd->prepare("UPDATE PANTALLA SET CodPantalla=? WHERE CodEvento=? AND IpPantalla=?");
        $actualizar = $sth->execute(array($codpantalla,$codevento,$ippantalla));
        if ($actualizar == TRUE) {
            $msg = 10; //actualizada correctamente el codigo
        } else {
            $msg = 11; //no se ha actualizado el codigo
        }

    }

}elseif(count($pantalla) > 1){
        try {
            $sth = $mbd->prepare("DELETE FROM PANTALLA WHERE CodEvento=? AND (CodPantalla=? OR IpPantalla=?)");
            $sth->execute(array($codevento,$codpantalla,$ippantalla));

            $mbd->beginTransaction();
            $sth = $mbd->prepare("INSERT INTO PANTALLA VALUES(?,?,?,?)");

            if ($sth->execute(array($codevento, $codpantalla, $ippantalla, $nompantalla))) {
                $mbd->commit();
                $msg = 12; //exito
            } else {
                $msg = 13; //error en el insert
            }

        } catch (Exception $e) {
            $msg = 14;
        }

}else{
    $msg = 15; //No deberia entrar nunca en esta condicion
}


//$json = '{"mensaje": $msg}';
echo json_encode($msg);
return json_encode($msg);


?>