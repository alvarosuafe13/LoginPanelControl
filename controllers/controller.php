<?php

include_once 'models/screen.php';
include_once 'models/user.php';
include_once 'controllers/user_session.php';


class Controller{

    public function goToControlPanel($userForm, $passForm,$codEventoForm,$serverScreen){

        //Guardamos en el objecto el codigo de evento que tiene el administrador
        $serverScreen->setCodEvento($userForm,$passForm);
        //Obtenemos el codigo de evento
        $codEvento = $serverScreen->getCodEvento();

        $serverScreen->setIpCentral($codEvento);

        $ipServer = $serverScreen->getIpCentral();

        if ($ipServer == null){
            $errorLogin = "El panel Central no está encendido o registrado en la Base de Datos";
            include_once 'views/login.php';

        }

        $url = $ipServer."/ControlPaneles/Central";


      //  $result = get_headers("http://192.168.181.3/ControlPaneles/Central");

        //Hacemos una peticion a la supuesta pagina que puede administrar y si da error quiere decir que
        //el administrador que intenta hacer login es el administrador de otro evento
        //y no tiene permiso para administrar este evento
       /* $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT_MS,100);
        $result = curl_exec($curl);*/

        /*$userSession->setCurrentUser($userForm);
        $user->setUser($userForm);
        $admin = $user->getNombre();*/
        header('location: http://'.$url.'/index.php?admin='.$userForm.'&codEvento='.$codEventoForm);
        die();
/*
        if ($result !== false) {

            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($statusCode == 404) {
                $errorLogin = "No puedes administrar los paneles de este evento";
                include_once 'views/login.php';
            }
            else {

                $userSession->setCurrentUser($userForm);
                $user->setUser($userForm);
                $admin = $user->getNombre();
                //echo"existe";
                header('location: http://'.$url.'/index.php?admin='.$admin);
            }
        }
        else {
            $errorLogin = "No puedes administrar los paneles de este evento! ";
            include_once 'views/login.php';
        }
*/

        // include_once 'views/home.php';

    }


}



?>