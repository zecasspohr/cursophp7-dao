<?php
    require_once ("config.php");

//    $sql = new Sql();
//    $usuarios = $sql->select("SELECT * FROM USUARIOS");
//    echo json_encode($usuarios);
//    $lista = Usuario::getList();
//    echo json_encode($lista);


//    $search = Usuario::search("ro");
//    echo json_encode($search);
    
    $usu = new Usuario();
    $usu->login("root", "root");
    
    
    echo $usu;
    