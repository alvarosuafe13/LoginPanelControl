<?php
include_once 'models/user.php';
include_once 'controllers/user_session.php';
include_once 'models/screen.php';
include_once 'controllers/controller.php';

//$userSession = new UserSession();
$user = new User();
$serverScreen = new Screen();

//Si ya hay sesion activar redirigir al control de paneles
/*if(isset($_SESSION['admin'])){
    $controller = new Controller();
    $user->setUser($userSession->getCurrentUser());
    $ipServer = $_SESSION['ip'];
    $url = $ipServer."/ControlPaneles/Central";
    $admin = $user->getNombre();
    header('location: http://'.$url.'/index.php?admin='.$admin);


}else*/
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['codEvento'])){

    $userForm = $_POST['username'];
    $passForm = $_POST['password'];
    $codEventoForm = $_POST['codEvento'];

    //Si el usuario y contraseña son correctos
    if($user->userExists($userForm, $passForm)){


        $controller = new Controller();
        $controller->goToControlPanel($userForm, $passForm,$codEventoForm,$serverScreen);

    }else{
        //Nombre o contraseña incorrectos
        $errorLogin = "Nombre de administrador y/o contraseña incorrecto";
        include_once 'views/login.php';
    }
}else{
    //echo "login";
    include_once 'views/login.php';
}



?>