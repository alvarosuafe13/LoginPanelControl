<?php

class UserSession{

    public function __construct(){
        session_start();
    }

    public function setCurrentUser($user){
        $_SESSION['admin'] = $user;
    }

    public function getCurrentUser(){
        return $_SESSION['admin'];
    }

    public function closeSession(){
        session_unset();
        session_destroy();
    }
}

?>
